<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_klasifikasi_pelanggan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Query untuk menghapus semua data dari tabel 'transaksi'
    $sql1 = "DELETE FROM transaksi";
    if ($conn->query($sql1) === FALSE) {
        throw new Exception("Error saat menghapus data: " . $conn->error);
    }

    // Query untuk mereset AUTO_INCREMENT menjadi 1
    $sql2 = "ALTER TABLE transaksi AUTO_INCREMENT = 1";
    if ($conn->query($sql2) === FALSE) {
        throw new Exception("Error saat mereset AUTO_INCREMENT: " . $conn->error);
    }

    // Commit transaksi
    $conn->commit();
    echo "Semua data transaksi berhasil dihapus.";
} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollback();
    echo "Gagal menghapus data: " . $e->getMessage();
}

// Tutup koneksi
$conn->close();
