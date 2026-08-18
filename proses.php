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
include "modelNaiveBayes.php";
include "includes/config.php";

$queryIds = mysqli_query($koneksi, "SELECT DISTINCT id_transaksi FROM probabilitas_likelihood ORDER BY id_transaksi ASC");
$transactionIds = [];
while ($rowId = mysqli_fetch_assoc($queryIds)) {
    $transactionIds[] = $rowId['id_transaksi'];
}

$id_to_show = isset($_GET['id']) ? intval($_GET['id']) : (empty($transactionIds) ? 1 : $transactionIds[0]);

$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
$query2 = mysqli_query($koneksi, "SELECT * FROM transaksi_terlabel");
$query3 = mysqli_query($koneksi, "SELECT * FROM probabilitas_prior");
$query4 = mysqli_query($koneksi, "SELECT * FROM probabilitas_posterior WHERE id_transaksi = '$id_to_show'");
$queryLikelihood = mysqli_query($koneksi, "SELECT * FROM probabilitas_likelihood WHERE id_transaksi = '$id_to_show'");

?>

<body>
    <div class="container">
        <?php
        include "sidebar.php";
        ?>
        <main>
            <h2>Proses Klasifikasi</h2>


            <!-- end of insights -->
            <div class="container-form">

                <div class="recent-naive">
                    <h3>Data yang Digunakan</h3>
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
                                    <td><?php echo $row['tanggalTransaksi'] ?></td>
                                    <td><?php echo $row['usiaPengguna'] ?></td>
                                    <td><?php echo $row['usiaAkun'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <h2>Tahap 1: Menentukan Kelas AWal dan Menghitung Probabilitas Prior</h2>
                <div class="recent-naive">
                    <h3>Hasil Kriteria Aturan Kelas</h3>
                    <table>
                        <thead>
                            <th>ID Transaksi</th>
                            <th>Jumlah Transaksi</th>
                            <th>Usia Akun</th>
                            <th>Metode Pembayaran</th>
                            <th>Kategori Produk</th>
                            <th>Kelas</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_array($query2)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id_transaksi'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['jumlahTransaksi'], 0, ',', '.'); ?></td>
                                    <td><?php echo $row['usiaAkun'] ?></td>
                                    <td><?php echo $row['metodePembayaran'] ?></td>
                                    <td><?php echo $row['kategoriProduk'] ?></td>
                                    <td><?php echo $row['kelas'] ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <h3>Probabilitas Prior</h3>
                    <table>
                        <thead>
                            <th>Kategori</th>
                            <th>Probabilitas Prior</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_array($query3)) {
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
                <h3 for="id_select">Pilih ID</h3>
                <form action="proses.php#id_select" method="get">
                    <div class="form">

                        <div class="form1">
                            <label for="id_select">ID Transaksi:</label>
                            <br>
                            <select id="id_select" name="id">
                                <?php foreach ($transactionIds as $id) : ?>
                                    <option value="<?php echo $id; ?>" <?php echo ($id == $id_to_show) ? 'selected' : ''; ?>>
                                        <?php echo $id; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <br>
                            <div class="bt-form">
                                <button type="submit" name="submit" class="btn btn-primary">View</button>
                            </div>

                        </div>
                    </div>
                </form>
                <br>
                <h2>Tahap 2: Perhitungan Likelihood</h2>
                <div class="recent-naive">
                    <h3>Probabilitas Likelihood (ID_Transaksi: <?php echo $id_to_show; ?>)</h3>
                    <table>
                        <thead>
                            <th>Kategori</th>
                            <th>Atribut</th>
                            <th>Nilai Atribut</th>
                            <th>Probabilitas</th>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($queryLikelihood) > 0) {
                                while ($row = mysqli_fetch_array($queryLikelihood)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['kategori'] ?></td>
                                        <td><?php echo $row['atribut'] ?></td>
                                        <td><?php echo $row['nilai_atribut'] ?></td>
                                        <td><?php echo number_format($row['probabilitas'], 3) ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">Data tidak ditemukan untuk ID Transaksi ini.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <h2>Tahap 3: Perhitungan Posterior</h2>
                <div class="recent-naive">
                    <h3>Probabilitas Posterior (ID_Transaksi: <?php echo $id_to_show; ?>)</h3>
                    <table>
                        <thead>
                            <th>Kategori</th>
                            <th>Probabilitas</th>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query4) > 0) {
                                while ($row = mysqli_fetch_array($query4)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['kategori'] ?></td>
                                        <td><?php echo number_format($row['probabilitas'], 3) ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">Data tidak ditemukan untuk ID Transaksi ini.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>



                <!-- end of container-form -->


            </div>



        </main>
        <!-- end of main -->
    </div>

</body>

</html>