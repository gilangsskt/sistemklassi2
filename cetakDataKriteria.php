<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="./styles/styleLaporan.css">
</head>
<?php
include "includes/config.php";
$query = mysqli_query($koneksi, "SELECT * FROM kriteria_klasifikasi");
?>

<body>

    <!-- <div class="header">
        <img src="./images/png" alt="Gambar">
    </div> -->

    <div class="title">
        <h3>Laporan Data Kriteria Aturan Kelas</h3>
    </div>
    <br><br>

    <div class="table-container">
        <table>
            <thead>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aturan Kelas</th>
            </thead>

            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['nama_kategori'] ?></td>
                        <td><?php echo $row['aturan_hybrid'] ?></td>
                    </tr>
                <?php
                }
                ?>

            </tbody>

        </table>
    </div>

    <div class="footer">
        Jakarta, <?php echo tgl_indo(date('Y-m-d')); ?><br>
        Mengetahui,<br><br><br><br><br>
        Manager
    </div>
    <script>
        window.print();
    </script>
</body>

</html>