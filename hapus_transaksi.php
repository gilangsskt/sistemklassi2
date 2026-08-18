<?php
require "includes/config.php";
$id = $_GET["id"];

if (hapus_transaksi($id) > 0) {
    echo "  <script>
                alert('Data berhasil di hapus');
                location.href='dataTransaksi.php';
            </script>";
    echo "databerhasil";
} else {
    echo "<script>
                alert('Data gagal di hapus');
                location.href='dataTransaksi.php';
        </script>";
}

?>

<!--  -->