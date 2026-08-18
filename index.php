<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klasifikasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="./styles/style.css">


</head>
<?php
include "includes/config.php";

$tabel = mysqli_query($koneksi, "SELECT * FROM transaksi;");

$query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM transaksi;");


if ($query) {
    $row = mysqli_fetch_assoc($query);
    $dataTransaksi = $row['total'];
    mysqli_free_result($query);
} else {

    $dataTransaksi = "data error";
}
$query2 = mysqli_query($koneksi, "SELECT SUM(jumlahTransaksi) AS total_transaksi FROM transaksi;");


if ($query2) {
    $row = mysqli_fetch_assoc($query2);
    $totalTransaksi = $row['total_transaksi'];


    mysqli_free_result($query2);
} else {

    $totalTransaksi = "error pada sum";
}
?>

<body>
    <div class="container">
        <?php
        include "sidebar.php";
        ?>

        <main>
            <h2>Dashboard > Welcome</h2>

            <div class="insights">
                <div class="card-1">
                    <span class="material-symbols-outlined">
                        credit_card
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Jumlah Data Transaksi</h3>
                            <h1><?php echo $dataTransaksi; ?></h1>
                        </div>
                    </div>
                </div>
                <!-- end of card-1 -->

                <div class="card-2">
                    <span class="material-symbols-outlined">
                        money_bag
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Transaksi</h3>
                            <h1><?php echo "Rp. " . number_format($totalTransaksi, 0, ',', '.'); ?></h1>
                        </div>
                    </div>
                </div>
                <!-- end of card-2 -->
            </div>

            <div class="recent-naive">
                <h2>Tabel Data Transaksi</h2>
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
                        while ($row = mysqli_fetch_array($tabel)) {
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

        </main>
        <!-- end of main -->
    </div>


</body>

</html>