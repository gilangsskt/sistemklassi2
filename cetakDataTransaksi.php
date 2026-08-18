<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="./styles/styleLaporan.css">
</head>
<?php
include "includes/config.php";
$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
?>

<body>

    <!-- <div class="header">
        <img src="./images/.png" alt="Gambar">
    </div> -->

    <div class="title">
        <h3>Laporan Data Transaksi</h3>
    </div>
    <br><br>

    <div class="table-container">
        <table>
            <thead>
                <th>ID Transaksi</th>
                <th>Kategori Produk</th>
                <th>Jumlah Transaksi</th>
                <th>Metode Pembayaran</th>
                <th>Jumlah Barang</th>
                <th>Tipe Perangkat</th>
                <th>Tanggal Transaksi</th>
                <th>Usia Pelanggan</th>
                <th>Usia Akun</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $row['id_transaksi'] ?></td>
                        <td><?php echo $row['kategoriProduk'] ?></td>
                        <td><?php echo "Rp. " . number_format($row['jumlahTransaksi'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['metodePembayaran'] ?></td>
                        <td><?php echo $row['jumlahBarang'] ?></td>
                        <td><?php echo $row['tipePerangkat'] ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['tanggalTransaksi'])); ?></td>
                        <td><?php echo $row['usiaPengguna'] ?></td>
                        <td><?php echo $row['usiaAkun'] ?></td>
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