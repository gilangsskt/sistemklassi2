<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="./styles/styleLaporan.css">
</head>
<?php
include "includes/config.php";
$query = mysqli_query($koneksi, "SELECT * FROM probabilitas_prior");
?>

<body>

    <!-- <div class="header">
        <img src="./images/png" alt="Gambar">
    </div> -->

    <div class="title">
        <h3>Laporan Data Probabilitas Prior</h3>
    </div>
    <br><br>

    <div class="table-container">
        <table>
            <thead>
                <th>Kategori</th>
                <th>Probabilitas Prior</th>
            </thead>

            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $row['kategori'] ?></td>
                        <td><?php echo number_format($row['probabilitas'], 3) ?></td>
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