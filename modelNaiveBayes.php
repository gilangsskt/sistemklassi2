<?php

// --- Koneksi ke Database ---
$koneksi = new mysqli("localhost", "root", "", "db_klasifikasi_pelanggan");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// --- Ambil Kategori & Aturan dari Database ---
$kriteriaRes = $koneksi->query("SELECT * FROM kriteria_klasifikasi");
$kelas = [];
$aturanKelas = [];
while ($row = $kriteriaRes->fetch_assoc()) {
    $kelas[] = $row['nama_kategori'];
    $aturanKelas[$row['nama_kategori']] = $row['aturan_hybrid'];
}

// --- Fungsi untuk Menentukan Kelas Awal (untuk Pelabelan Training Data) ---
function tentukanKelas($transaksi, $aturanKelas)
{
    foreach ($aturanKelas as $namaKelas => $aturan) {
        $expr = $aturan;
        $expr = str_replace("&gt;", ">", $expr);
        $expr = str_replace("&lt;", "<", $expr);
        // Ganti field dengan nilai transaksi
        $expr = str_replace("jumlahTransaksi", $transaksi['jumlahTransaksi'], $expr);
        $expr = str_replace("usiaAkun", $transaksi['usiaAkun'], $expr);
        // Hilangkan tanda kutip
        $expr = str_replace("'", "", $expr);
        // Ganti operator agar sesuai dengan sintaks PHP
        $expr = str_ireplace("AND", "&&", $expr);
        $expr = str_ireplace("OR", "||", $expr);

        // Evaluasi ekspresi dengan aman
        $hasil = false;
        @eval("\$hasil = ($expr);");
        if ($hasil) {
            return $namaKelas;
        }
    }
    return null; // Kembalikan null jika tidak ada kelas yang cocok
}

// --- Hapus dan Isi Ulang Tabel transaksi_terlabel ---
$koneksi->query("TRUNCATE TABLE transaksi_terlabel");
$dataTransaksiResult = $koneksi->query("SELECT * FROM transaksi");

// Siapkan statement INSERT untuk tabel transaksi_terlabel
$stmtInsertLabeled = $koneksi->prepare("INSERT INTO transaksi_terlabel (id_transaksi, jumlahTransaksi, usiaAkun, metodePembayaran, kategoriProduk, kelas) VALUES (?, ?, ?, ?, ?, ?)");

// Cek apakah prepare() berhasil
if ($stmtInsertLabeled === false) {
    die("Error preparing statement: " . $koneksi->error);
}

// Proses setiap data transaksi dan berikan label
while ($row = $dataTransaksiResult->fetch_assoc()) {
    $kelasLabel = tentukanKelas($row, $aturanKelas);
    if ($kelasLabel !== null) {
        // Tipe data untuk bind_param
        // i = integer
        // d = double (untuk DECIMAL)
        // s = string
        $stmtInsertLabeled->bind_param("idisss", $row['id_transaksi'], $row['jumlahTransaksi'], $row['usiaAkun'], $row['metodePembayaran'], $row['kategoriProduk'], $kelasLabel);
        $stmtInsertLabeled->execute();
    }
}

// Tutup statement
$stmtInsertLabeled->close();

// --- Ambil Semua Data Training dari Tabel Baru ---
$trainDataResult = $koneksi->query("SELECT * FROM transaksi_terlabel");
$trainData = [];
while ($row = $trainDataResult->fetch_assoc()) {
    $trainData[] = $row;
}

// --- Hitung Prior Probability (dengan Laplace Smoothing) ---
$totalData = count($trainData);
$jumlahKelas = count($kelas);
$prior = [];
foreach ($kelas as $c) {
    $count = count(array_filter($trainData, fn($d) => $d['kelas'] == $c));
    $prior[$c] = ($count + 1) / ($totalData + $jumlahKelas);
}

// --- Simpan Probabilitas Prior ke Database ---
$koneksi->query("TRUNCATE TABLE probabilitas_prior");
$stmtPrior = $koneksi->prepare("INSERT INTO probabilitas_prior (kategori, probabilitas) VALUES (?, ?)");
foreach ($prior as $kategori => $prob) {
    $stmtPrior->bind_param("sd", $kategori, $prob);
    $stmtPrior->execute();
}
$stmtPrior->close();

// --- Definisikan Nilai Unik untuk Setiap Atribut Kategorikal ---
$nilaiUnik = [
    'metodePembayaran' => array_unique(array_column($trainData, 'metodePembayaran')),
    'kategoriProduk'   => array_unique(array_column($trainData, 'kategoriProduk')),
    'amount'           => ["Low", "Medium", "High"],
    'usia'             => ["<=180", ">180"]
];

// --- Fungsi untuk Mengkategorikan Atribut Numerik ---
function kategoriJumlah($jml)
{
    if ($jml > 5000000) return "High";
    if ($jml > 2000000) return "Medium";
    return "Low";
}

function kategoriUsia($usia)
{
    return ($usia > 180) ? ">180" : "<=180";
}

// --- Fungsi untuk Menghitung Likelihood (dengan Laplace Smoothing) ---
function hitungLikelihood($atribut, $nilai, $kelas, $data, $nilaiUnik)
{
    // Filter data berdasarkan kelas dan atribut=nilai
    $countXC = 0;
    foreach ($data as $d) {
        if (isset($d[$atribut]) && $d[$atribut] == $nilai && $d['kelas'] == $kelas) {
            $countXC++;
        }
    }

    // Filter data berdasarkan kelas saja
    $countC = 0;
    foreach ($data as $d) {
        if ($d['kelas'] == $kelas) {
            $countC++;
        }
    }

    $V = count($nilaiUnik[$atribut]);
    return ($countXC + 1) / ($countC + $V);
}

// --- Hapus Hasil Lama dari Tabel ---
$koneksi->query("TRUNCATE TABLE hasil_klasifikasi");
$koneksi->query("TRUNCATE TABLE probabilitas_posterior"); // Bersihkan juga tabel posterior
$koneksi->query("TRUNCATE TABLE probabilitas_likelihood"); // Tambahkan baris ini untuk membersihkan tabel likelihood

// --- Siapkan Statement INSERT di Luar Loop untuk Efisiensi ---
$stmtPrediksi = $koneksi->prepare("INSERT INTO hasil_klasifikasi (id_transaksi, kategori_prediksi, probabilitas_prediksi) VALUES (?, ?, ?)");
$stmtPosterior = $koneksi->prepare("INSERT INTO probabilitas_posterior (id_transaksi, kategori, probabilitas) VALUES (?, ?, ?)");
$stmtLikelihood = $koneksi->prepare("INSERT INTO probabilitas_likelihood (id_transaksi, kategori, atribut, nilai_atribut, probabilitas) VALUES (?, ?, ?, ?, ?)"); // Tambahkan statement untuk likelihood

// --- Proses Klasifikasi untuk Setiap Data ---
foreach ($trainData as $d) {
    $amountCat = kategoriJumlah($d['jumlahTransaksi']);
    $usiaCat   = kategoriUsia($d['usiaAkun']);

    // Ubah data training untuk atribut 'amount' dan 'usia' agar sesuai saat perhitungan likelihood
    $trainDataWithCats = array_map(function ($x) {
        return array_merge($x, [
            'amount' => kategoriJumlah($x['jumlahTransaksi']),
            'usia'   => kategoriUsia($x['usiaAkun'])
        ]);
    }, $trainData);

    $posterior = [];
    foreach ($kelas as $c) {
        $score = $prior[$c];

        // Hitung dan simpan likelihood untuk 'metodePembayaran'

        $likelihood_metode = hitungLikelihood('metodePembayaran', $d['metodePembayaran'], $c, $trainDataWithCats, $nilaiUnik);
        $score *= $likelihood_metode;
        $atribut_metode = 'metodePembayaran'; // Store the literal in a variable
        $nilai_metode = $d['metodePembayaran']; // Store the value in a variable
        $stmtLikelihood->bind_param("isssd", $d['id_transaksi'], $c, $atribut_metode, $nilai_metode, $likelihood_metode);
        $stmtLikelihood->execute();

        // Hitung dan simpan likelihood untuk 'kategoriProduk'
        $likelihood_produk = hitungLikelihood('kategoriProduk', $d['kategoriProduk'], $c, $trainDataWithCats, $nilaiUnik);
        $score *= $likelihood_produk;
        $atribut_produk = 'kategoriProduk'; // Store the literal in a variable
        $nilai_produk = $d['kategoriProduk']; // Store the value in a variable
        $stmtLikelihood->bind_param("isssd", $d['id_transaksi'], $c, $atribut_produk, $nilai_produk, $likelihood_produk);
        $stmtLikelihood->execute();

        // Hitung dan simpan likelihood untuk 'amount'
        $likelihood_amount = hitungLikelihood('amount', $amountCat, $c, $trainDataWithCats, $nilaiUnik);
        $score *= $likelihood_amount;
        $atribut_amount = 'amount'; // Store the literal in a variable
        $nilai_amount = $amountCat; // Store the value in a variable
        $stmtLikelihood->bind_param("isssd", $d['id_transaksi'], $c, $atribut_amount, $nilai_amount, $likelihood_amount);
        $stmtLikelihood->execute();

        // Hitung dan simpan likelihood untuk 'usia'
        $likelihood_usia = hitungLikelihood('usia', $usiaCat, $c, $trainDataWithCats, $nilaiUnik);
        $score *= $likelihood_usia;
        $atribut_usia = 'usia'; // Store the literal in a variable
        $nilai_usia = $usiaCat; // Store the value in a variable
        $stmtLikelihood->bind_param("isssd", $d['id_transaksi'], $c, $atribut_usia, $nilai_usia, $likelihood_usia);
        $stmtLikelihood->execute();

        $posterior[$c] = $score;
    }

    // Normalisasi probabilitas posterior
    $sumScore = array_sum($posterior);
    if ($sumScore > 0) {
        foreach ($posterior as $c => $s) {
            $posterior[$c] = $s / $sumScore;
        }
    }

    // --- Simpan Semua Probabilitas Posterior ke Tabel Baru ---
    foreach ($posterior as $kategori => $probabilitas) {
        $stmtPosterior->bind_param("isd", $d['id_transaksi'], $kategori, $probabilitas);
        $stmtPosterior->execute();
    }

    // --- Tentukan Prediksi dan Simpan ke Tabel Hasil Klasifikasi ---
    $prediksi = array_keys($posterior, max($posterior))[0];
    $prob = max($posterior);

    $stmtPrediksi->bind_param("isd", $d['id_transaksi'], $prediksi, $prob);
    $stmtPrediksi->execute();
}

// --- Tutup Statement Setelah Selesai ---
$stmtPrediksi->close();
$stmtPosterior->close();
$stmtLikelihood->close();
$koneksi->close();
