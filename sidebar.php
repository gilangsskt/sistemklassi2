<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Klasifikasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="./styles/style.css">


</head>
<?php
// Ambil URL saat ini
$current_page = basename($_SERVER['REQUEST_URI']);

// Fungsi untuk menambahkan kelas 'active' jika halaman saat ini sesuai dengan parameter
function setActiveClass($page)
{
    global $current_page;

    // Setel 'dashboard.html' sebagai halaman aktif default jika tidak ada halaman tertentu yang disetel
    if ($current_page == '' || $current_page == 'dashboard.php') {
        $current_page = 'dashboard.php';
    }

    return $current_page == $page ? 'active' : '';
}
?>
<script>
    function showAlert() {
        var result = window.confirm("Apakah Anda yakin ingin Keluar?");
        if (result) {
            window.location.href = 'logout.php';
        } else {
            window.location.href = 'index.php';
        }
    }
</script>


<aside>
    <div class="top">
        <div class="logo">
            <h1>Klasifikasi.</h1>
        </div>
        <div class="close" id="close-btn">
            <span class="material-symbols-outlined">
                close
            </span>
        </div>
    </div>
    <div class="sidebar">
        <!-- Dashboard -->
        <a href="index.php" class="<?php echo setActiveClass('index.php'); ?>">
            <span class="material-symbols-outlined">
                grid_view
            </span>
            <h3>Dashboard</h3>
        </a>
        <!-- Data Transaksi -->
        <a href="dataTransaksi.php" class="<?php echo setActiveClass('dataTransaksi.php'); ?>">
            <span class="material-symbols-outlined">
                credit_card
            </span>
            <h3>Data Transaksi</h3>
        </a>
        <!-- Bobot Kriteria -->
        <a href="kriteriaAturan.php" class="<?php echo setActiveClass('kriteriaAturan.php'); ?>">
            <span class="material-symbols-outlined">
                book_5
            </span>
            <h3>Kriteria Aturan</h3>
        </a>
        <!-- Penilaian -->
        <a href="proses.php" class="<?php echo setActiveClass('proses.php'); ?>">
            <span class="material-symbols-outlined">
                progress_activity
            </span>

            <h3>Proses</h3>
        </a>
        <a href="hasil.php" class="<?php echo setActiveClass('hasil.php'); ?>">
            <span class="material-symbols-outlined">
                analytics
            </span>
            <h3>Hasil</h3>
        </a>
        <!-- Laporan -->
        <a href="laporan.php" class="<?php echo setActiveClass('laporan.php'); ?>">
            <span class="material-symbols-outlined">
                print
            </span>
            <h3>Laporan</h3>
        </a>
        <!-- Logout -->
        <a href="#" onclick="showAlert()">
            <span class="material-symbols-outlined">
                logout
            </span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>

<!-- end of aside -->