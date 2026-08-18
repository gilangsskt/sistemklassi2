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
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi= $id");
$getRow = mysqli_fetch_array($transaksi);
$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
$hapusSemua = mysqli_query($koneksi, "SELECT * FROM transaksi");

if (isset($_POST["submit"])) {

    if (ubah_transaksi($_POST) > 0) {
        echo "  <script>
                    alert('data berhasil di ubah');
                    location.href='dataTransaksi.php';
                </script>";
        include "./hitung.php";
    } else {
        echo "  <script>
                    alert('data gagal di ubah');
                    location.href='dataTransaksi.php';
                </script>";
    }
}
?>

<body>
    <div class="container">
        <?php
        include "sidebar.php";
        ?>
        <main>
            <h2>Data Transaksi</h2>


            <!-- end of insights -->
            <div class="container-form">
                <form action="" method="post">
                    <div class="form">
                        <div class="form1">
                            <input type="hidden" name="id" value="<?= $getRow["id_transaksi"]  ?>">
                        </div>

                        <div class="form1">
                            <label for="kategoriProduk">Kategori Produk</label>
                            <br>
                            <select id="kategoriProduk" name="kategoriProduk">
                                <option value="<?= $getRow["kategoriProduk"] ?>"><?= $getRow["kategoriProduk"] ?></option>
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
                            <input type="number" id="jumlahTransaksi" name="jumlahTransaksi" value="<?= $getRow["jumlahTransaksi"] ?>">
                        </div>
                        <div class="form1">
                            <label for="metodePembayaran">Metode Pembayaran</label>
                            <br>
                            <select id="metodePembayaran" name="metodePembayaran">
                                <option value="<?= $getRow["metodePembayaran"] ?>"><?= $getRow["metodePembayaran"] ?></option>
                                <option value="Kartu Kredit">Kartu Kredit</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        <div class="form1">
                            <label for="jumlahBarang">Jumlah Barang</label>
                            <br>
                            <input type="number" id="jumlahBarang" name="jumlahBarang" value="<?= $getRow["jumlahBarang"] ?>">
                        </div>

                        <div class="form1">
                            <label for="tipePerangkat">Tipe Perangkat</label>
                            <br>
                            <select id="tipePerangkat" name="tipePerangkat">
                                <option value="<?= $getRow["tipePerangkat"] ?>"><?= $getRow["tipePerangkat"] ?></option>
                                <option value="Desktop">Desktop/Komputer</option>
                                <option value="Mobile">Mobile/HP</option>
                                <option value="Tablet">Tablet</option>
                            </select>
                        </div>

                        <div class="form1">
                            <label for="f4">Usia Pelanggan</label>
                            <br>
                            <input type="number" id="f4" name="usiaPengguna" value="<?= $getRow["usiaPengguna"] ?>">
                        </div>


                        <div class="form1">
                            <label for="usiaAkun">Usia Akun (Jumlah Hari)</label>
                            <br>
                            <input type="number" id="usiaAkun" name="usiaAkun" value="<?= $getRow["usiaAkun"] ?>">
                        </div>
                        <br>
                        <div class="bt-form">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <button type="submit" name="cancel" onclick="location.href='dataTransaksi.php'" class="btn btn-primary">Cancel</button>
                        </div>





                        <!-- end of input -->
                    </div>
                </form>

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