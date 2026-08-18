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
$query = mysqli_query($koneksi, "SELECT h.id_transaksi, t.jumlahTransaksi, t.usiaAkun, t.metodePembayaran, t.kategoriProduk, h.kategori_prediksi, h.probabilitas_prediksi
                FROM hasil_klasifikasi h
                JOIN transaksi t ON h.id_transaksi = t.id_transaksi");
?>

<body>
    <!-- <div class="header">
        <img src="./images/.png" alt="Gambar">
    </div> -->
    <div class="title">
        <h3>Laporan Data Hasil Klasifikasi</h3>
    </div>
    <br>
    <br>

    <div class="table-container">
        <table>
            <thead>
                <th>ID Transaksi</th>
                <th>Jumlah Transaksi</th>
                <th>Usia Akun</th>
                <th>Metode Pembayaran</th>
                <th>Kategori Produk</th>
                <th>Kategori Prediksi</th>
                <th>Probabilitas</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $row['id_transaksi'] ?></td>
                        <td><?php echo "Rp. " . number_format($row['jumlahTransaksi'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['usiaAkun'] ?></td>
                        <td><?php echo $row['metodePembayaran'] ?></td>
                        <td><?php echo $row['kategoriProduk'] ?></td>
                        <td style='font-weight: bold;'><?php echo htmlspecialchars($row['kategori_prediksi']); ?></td>
                        <td><?php echo round($row['probabilitas_prediksi'] * 100, 2) . "%"; ?></td>
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