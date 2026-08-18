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
$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
$hapusSemua = mysqli_query($koneksi, "SELECT * FROM transaksi");


if (isset($_POST["submit"])) {

    if (tambahTransaksi($_POST) > 0) {
        echo "  <script>
                    alert('data berhasil di tambah');
                    location.href='dataTransaksi.php';
                </script>";
    } else {
        echo "<script>location.href='dataTransaksi.php'</script>";
    }
}
?>

<body>
    <div class="container">
        <?php
        include "sidebar.php";
        ?>
        <main>
            <h2>Form Data Transaksi</h2>


            <!-- end of insights -->
            <div class="container-form">
                <form action="" method="post">
                    <div class="form">

                        <div class="form1">
                            <label for="kategoriProduk">Kategori Produk</label>
                            <br>
                            <select id="kategoriProduk" name="kategoriProduk">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Pakaian">Pakaian</option>
                                <option value="Otomotif">Otomotif</option>
                                <option value="Furnitur">Furnitur</option>
                                <option value="Travel">Travel</option>
                                <option value="Buku">Buku</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Kosmetik">Kosmetik</option>
                            </select>
                        </div>
                        <div class="form1">
                            <label for="jumlahTransaksi">Jumlah Transaksi(RP)</label>
                            <br>
                            <input type="number" id="jumlahTransaksi" name="jumlahTransaksi">
                        </div>
                        <div class="form1">
                            <label for="metodePembayaran">Metode Pembayaran</label>
                            <br>
                            <select id="metodePembayaran" name="metodePembayaran">
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                <option value="Kartu Kredit">Kartu Kredit</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        <div class="form1">
                            <label for="jumlahBarang">Jumlah Barang</label>
                            <br>
                            <input type="number" id="jumlahBarang" name="jumlahBarang">
                        </div>

                        <div class="form1">
                            <label for="tipePerangkat">Tipe Perangkat</label>
                            <br>
                            <select id="tipePerangkat" name="tipePerangkat">
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="Desktop">Desktop/Komputer</option>
                                <option value="Mobile">Mobile/HP</option>
                                <option value="Tablet">Tablet</option>
                            </select>
                        </div>
                        <div class="form1">
                            <label for="tgl">Tanggal Transaksi</label>
                            <br>
                            <input type="date" id="tgl" name="tanggalTransaksi">
                        </div>

                        <div class="form1">
                            <label for="f4">Usia Pelanggan</label>
                            <br>
                            <input type="number" id="f4" name="usiaPengguna">
                        </div>


                        <div class="form1">
                            <label for="usiaAkun">Usia Akun (Hari)</label>
                            <br>
                            <input type="number" id="usiaAkun" name="usiaAkun">
                        </div>
                        <br>
                        <div class="bt-form">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <button type="submit" name="cancel" onclick="location.href='dataTransaksi.php'" class="btn btn-primary">Cancel</button>
                        </div>

                        <br>

                        <div class="bt-form2">
                            <button type="button" class="btn btn-secondary" onclick="location.href='unggahFile.php'">Unggah File</button>

                        </div>
                        <br>
                        <div class="bt-form3">
                            <button type="button" class="btn btn-secondary" onclick="hapusSemuaData()">Hapus Semua Data</button>
                        </div>

                        <br>





                        <!-- end of input -->
                    </div>
                </form>
                <!-- end of form -->

                <div class="recent-naive">
                    <h2>Data Transaksi</h2>
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
                            <th>Aksi</th>
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
                                    <td class="bt-tabel">
                                        <div class="bt1">
                                            <a href="ubah_transaksi.php?id=<?= $row["id_transaksi"]; ?>">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </a>
                                        </div>
                                        <div class="bt2">
                                            <a href="hapus_transaksi.php?id=<?= $row["id_transaksi"]; ?>">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


                <!-- end of container-form -->


            </div>



        </main>
        <!-- end of main -->
    </div>
    <script>
        function hapusSemuaData() {
            // Tampilkan konfirmasi kepada pengguna sebelum menghapus
            if (confirm("Apakah Anda yakin ingin menghapus semua data transaksi? Tindakan ini tidak dapat dibatalkan.")) {
                // Buat permintaan HTTP (misalnya menggunakan fetch API) ke skrip di server
                fetch('hapusSemua.php', {
                        method: 'POST',
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Tampilkan pesan dari server
                        location.reload(); // Muat ulang halaman setelah berhasil
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data.');
                    });
            }
        }
    </script>

</body>

</html>