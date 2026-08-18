<?php
require "includes/config.php";
$id = $_GET["id"];

if (hapus_kriteria($koneksi, $id) > 0) {
    echo "  <script>
                alert('Data berhasil di hapus');
                location.href='kriteriaAturan.php';
            </script>";
    echo "databerhasil";
} else {
    echo "<script>
                alert('Data gagal di hapus');
                location.href='kriteriaAturan.php';
        </script>";
}
?>
<!--  -->