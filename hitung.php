<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_vendor";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel vendor
$sql = "SELECT * FROM vendor";
$result = $conn->query($sql);

$vendors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vendors[$row['id_vendor']] = $row['nama_vendor'];
    }
} else {
    die("0 hasil dari tabel vendor");
}

// Mengambil bobot dari tabel bobot
$sql = "SELECT * FROM bobot";
$result = $conn->query($sql);

$weights = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $weights[$row['nama_bobot']] = $row['nilai_bobot'];
    }
} else {
    die("0 hasil dari tabel bobot");
}

// Mengambil data dari tabel penilaian
$sql = "SELECT * FROM penilaian";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die("0 hasil dari tabel penilaian");
}

// Fungsi untuk mendapatkan nilai maksimum untuk setiap kolom
function get_max($data, $col)
{
    $col_data = array_column($data, $col);
    return max($col_data);
}

// Fungsi untuk normalisasi benefit
function normalize_benefit($value, $max)
{
    return $value / $max;
}

$columns = array_keys($weights);
$max_values = [];

// Mendapatkan nilai maksimum untuk setiap kolom
foreach ($columns as $col) {
    $max_values[$col] = get_max($data, $col);
}

// Normalisasi data
$normalized_data = [];
foreach ($data as $row) {
    $normalized_row = ['id_vendor' => $row['id_vendor']];
    foreach ($columns as $col) {
        $max = $max_values[$col];
        $normalized_row[$col] = normalize_benefit($row[$col], $max);
    }
    $normalized_data[] = $normalized_row;
}

// Hitung skor total untuk setiap vendor
$scores = [];
foreach ($normalized_data as $row) {
    $total_score = 0;
    foreach ($columns as $col) {
        $total_score += $row[$col] * $weights[$col];
    }
    $scores[] = [
        'id_vendor' => $row['id_vendor'],
        'skor' => $total_score
    ];
}

// Tampilkan hasil normalisasi dan skor
foreach ($normalized_data as $row) {
    echo "Vendor ID " . $row['id_vendor'] . ": ";
    foreach ($columns as $col) {
        echo $col . " = " . number_format($row[$col], 4) . " ";
    }
    echo "<br>";
}

echo "<br>Skor Total:<br>";
foreach ($scores as $score) {
    echo "Vendor ID " . $score['id_vendor'] . ": " . number_format($score['skor'], 4) . "<br>";
}

// Menyimpan hasil normalisasi ke tabel normalisasi
$conn->query("TRUNCATE TABLE normalisasi"); // Mengosongkan tabel sebelum mengisi data baru

foreach ($normalized_data as $row) {
    $id_vendor = $row['id_vendor'];
    $sql = "INSERT INTO normalisasi (id_vendor, " . implode(", ", array_keys($row)) . ")
            VALUES ('$id_vendor', " . implode(", ", array_map(function ($value) {
        return "'$value'";
    }, array_values($row))) . ")";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menyimpan hasil skor ke tabel skor
$conn->query("TRUNCATE TABLE skor"); // Mengosongkan tabel sebelum mengisi data baru

foreach ($scores as $score) {
    $id_vendor = $score['id_vendor'];
    $skor = $score['skor'];

    $sql = "INSERT INTO skor (id_vendor, skor)
            VALUES ('$id_vendor', '$skor')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

echo "Data normalisasi dan skor berhasil disimpan";
$conn->close();
?>
<!--  -->