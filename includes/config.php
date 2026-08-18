<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_klasifikasi_pelanggan");
function tambahTransaksi($data)
{
    global $koneksi;
    $kategoriProduk   = htmlspecialchars($data["kategoriProduk"]);
    $jumlahTransaksi  = intval($data["jumlahTransaksi"]);
    $metodePembayaran = htmlspecialchars($data["metodePembayaran"]);
    $jumlahBarang     = intval($data["jumlahBarang"]);
    $tipePerangkat    = htmlspecialchars($data["tipePerangkat"]);
    $tanggalTransaksi = htmlspecialchars($data["tanggalTransaksi"]);
    $usiaPengguna     = intval($data["usiaPengguna"]);
    $usiaAkun         = intval($data["usiaAkun"]);

    $query = "INSERT INTO transaksi 
              ( kategoriProduk, jumlahTransaksi, metodePembayaran, jumlahBarang, tipePerangkat, tanggalTransaksi, usiaPengguna, usiaAkun) 
              VALUES 
              ('$kategoriProduk', $jumlahTransaksi, '$metodePembayaran', $jumlahBarang, '$tipePerangkat', '$tanggalTransaksi', $usiaPengguna, $usiaAkun)";

    if (!mysqli_query($koneksi, $query)) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}


function tambahDataDariFile($file)
{
    // Detail koneksi database
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "db_klasifikasi_pelanggan";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return "Koneksi ke database gagal: " . $conn->connect_error;
    }

    // Periksa apakah file berhasil diunggah
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Terjadi kesalahan saat mengunggah file. Kode error: " . $file['error'];
    }

    $filePath = $file['tmp_name'];

    if (($handle = fopen($filePath, "r")) !== FALSE) {
        // Lewati baris header
        fgetcsv($handle);

        $total_added = 0;

        // Query tanpa id_transaksi (auto increment)
        $sql = "INSERT INTO transaksi 
                (kategoriProduk, jumlahTransaksi, metodePembayaran, jumlahBarang, tipePerangkat, tanggalTransaksi, usiaPengguna, usiaAkun) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameter: s = string, d = double, i = integer
        $stmt->bind_param(
            "sdsssssi",
            $kategoriProduk,
            $jumlahTransaksi,
            $metodePembayaran,
            $jumlahBarang,
            $tipePerangkat,
            $tanggalTransaksi,
            $usiaPengguna,
            $usiaAkun
        );

        $lineNumber = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $lineNumber++;

            // Lewati baris kosong / tidak lengkap
            if (count($data) < 9) continue;

            // Lewati baris header tambahan
            if ($data[0] === "id_transaksi") continue;

            // Ambil data CSV (mulai index 1 karena id_transaksi dilewati)
            $kategoriProduk    = $data[1];
            $jumlahTransaksi   = (float)$data[2];
            $metodePembayaran  = $data[3];
            $jumlahBarang      = (int)$data[4];
            $tipePerangkat     = $data[5];
            $tanggalTransaksi  = date('Y-m-d', strtotime($data[6]));
            $usiaPengguna      = (int)$data[7];
            $usiaAkun          = (int)$data[8];

            if ($stmt->execute()) {
                $total_added++;
            }
        }

        fclose($handle);
        $stmt->close();
        $conn->close();

        return "Berhasil menambahkan " . $total_added . " baris data.";
    } else {
        return "Gagal membuka file.";
    }
}

function ubah_transaksi($data)
{
    global $koneksi;

    $id = $data["id"];
    $kategoriProduk = htmlspecialchars($data["kategoriProduk"]);
    $jumlahTransaksi  = intval($data["jumlahTransaksi"]);
    $metodePembayaran = htmlspecialchars($data["metodePembayaran"]);
    $jumlahBarang     = intval($data["jumlahBarang"]);
    $tipePerangkat    = htmlspecialchars($data["tipePerangkat"]);
    $usiaPengguna     = intval($data["usiaPengguna"]);
    $usiaAkun         = intval($data["usiaAkun"]);

    $query = "UPDATE transaksi SET 
                kategoriProduk = '$kategoriProduk',
                jumlahTransaksi = $jumlahTransaksi,
                metodePembayaran = '$metodePembayaran',
                jumlahBarang = $jumlahBarang,
                tipePerangkat = '$tipePerangkat',
                usiaPengguna = $usiaPengguna,
                usiaAkun = $usiaAkun
                WHERE id_transaksi = $id";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}



function tambahKriteriaKlasifikasi($kategori, $conditions)
{
    global $koneksi;

    // Periksa koneksi
    if ($koneksi->connect_error) {
        // Return 0 jika koneksi gagal
        return 0;
    }

    // --- Langkah 1: Periksa apakah nama_kategori sudah ada di database ---
    $check_sql = "SELECT COUNT(*) FROM kriteria_klasifikasi WHERE nama_kategori = ?";
    $check_stmt = $koneksi->prepare($check_sql);

    // Periksa apakah prepare statement berhasil
    if (!$check_stmt) {
        // Gagal membuat prepared statement, kembalikan 0
        return 0;
    }

    $check_stmt->bind_param("s", $kategori);
    $check_stmt->execute();

    // Dapatkan hasil dari statement
    $result = $check_stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    $check_stmt->close();

    // Jika nama_kategori sudah ada (count > 0), kembalikan 2
    if ($count > 0) {
        echo "  <script>
                alert('Tidak Dapat ditambah karna sudah ada data');
                location.href='kriteriaAturan.php';
            </script>";

        return 2;
    }

    // --- Langkah 2: Bangun string aturan_hybrid ---
    $aturan_hybrid = "";
    $condition_count = count($conditions);

    for ($i = 0; $i < $condition_count; $i++) {
        $condition = $conditions[$i];

        // Sanitize input
        $attribute = $koneksi->real_escape_string($condition['attribute']);
        $operator = $koneksi->real_escape_string($condition['operator']);
        $value = $koneksi->real_escape_string($condition['value']);
        $logic = ($i < $condition_count - 1) ? " " . $koneksi->real_escape_string($condition['logic']) . " " : "";

        // Pastikan nilai string diapit oleh kutip tunggal
        $aturan_hybrid .= "{$attribute} {$operator} '{$value}'{$logic}";
    }

    // --- Langkah 3: Lakukan operasi INSERT ---
    $insert_sql = "INSERT INTO kriteria_klasifikasi (nama_kategori, aturan_hybrid) VALUES (?, ?)";
    $insert_stmt = $koneksi->prepare($insert_sql);

    // Periksa apakah prepare statement berhasil
    if (!$insert_stmt) {
        // Gagal membuat prepared statement, kembalikan 0
        return 0;
    }

    $insert_stmt->bind_param("ss", $kategori, $aturan_hybrid);

    // Jalankan query dan periksa hasilnya
    if ($insert_stmt->execute()) {
        $insert_stmt->close();
        return 1; // Berhasil
    } else {
        $insert_stmt->close();
        return 0; // Gagal
    }
}

function ubah_kriteria($data)
{
    global $koneksi;

    $id = $data["id"];
    $nama_kategori = htmlspecialchars($data["nama_kategori"]);
    $aturanHybrid = htmlspecialchars($data["aturan_hybrid"]);


    $query = "UPDATE kriteria_klasifikasi SET 
                nama_kategori = '$nama_kategori',
                aturan_hybrid = '$aturanHybrid' 
                WHERE id_kriteria = $id";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}



function tambah_vendor($data)
{
    global $koneksi;
    $nama = htmlspecialchars($data["nama_vendor"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_telp = htmlspecialchars($data["no_telp"]);

    $query = "INSERT INTO vendor 
                VALUES 
                ('', '$nama', '$alamat', '$no_telp')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function hapusSemuaTransaksi($id)
{
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM transaksi;
ALTER TABLE transaksi AUTO_INCREMENT = 1;");

    return mysqli_affected_rows($koneksi);
}
function hapus_vendor($id)
{
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM vendor WHERE id_vendor = $id");

    return mysqli_affected_rows($koneksi);
}
function hapus_transaksi($id)
{
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = $id");

    return mysqli_affected_rows($koneksi);
}
function hapus_kriteria($koneksi, $id)
{
    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = mysqli_prepare($koneksi, "DELETE FROM kriteria_klasifikasi WHERE id_kriteria = ?");
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" artinya integer
    mysqli_stmt_execute($stmt);

    // Ambil jumlah baris yang terpengaruh
    $affected_rows = mysqli_stmt_affected_rows($stmt);

    // Tutup statement
    mysqli_stmt_close($stmt);

    return $affected_rows;
}














function get_columns($koneksi, $table)
{
    $columns = [];
    $sql = "SHOW COLUMNS FROM $table";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
    }
    return $columns;
}






function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    // variabel pecahkan[0] = tanggal
    // variabel pecahkan[1] = bulan
    // variabel pecahkan[2] = tahun
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}



?>











<!--  -->