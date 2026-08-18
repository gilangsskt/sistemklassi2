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


?>


<body>
    <div class="container">
        <?php
        include "sidebar.php";
        include "includes/config.php";


        // Menerima nilai filter dari URL
        $id_to_show = isset($_GET['id_transaksi']) ? $_GET['id_transaksi'] : '';
        $kategori_to_show = isset($_GET['kategori_prediksi']) ? $_GET['kategori_prediksi'] : '';
        $metode_to_show = isset($_GET['metode_pembayaran']) ? $_GET['metode_pembayaran'] : '';
        $produk_to_show = isset($_GET['kategori_produk']) ? $_GET['kategori_produk'] : '';
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_transaksi';
        $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

        // Query untuk mendapatkan opsi dropdown filter secara dinamis
        $kategoriPrediksiQuery = $koneksi->query("SELECT DISTINCT kategori_prediksi FROM hasil_klasifikasi");
        $kategoriPrediksiOptions = [];
        while ($row = mysqli_fetch_assoc($kategoriPrediksiQuery)) {
            $kategoriPrediksiOptions[] = $row['kategori_prediksi'];
        }

        $metodePembayaranQuery = $koneksi->query("SELECT DISTINCT metodePembayaran FROM transaksi");
        $metodePembayaranOptions = [];
        while ($row = mysqli_fetch_assoc($metodePembayaranQuery)) {
            $metodePembayaranOptions[] = $row['metodePembayaran'];
        }

        $kategoriProdukQuery = $koneksi->query("SELECT DISTINCT kategoriProduk FROM transaksi");
        $kategoriProdukOptions = [];
        while ($row = mysqli_fetch_assoc($kategoriProdukQuery)) {
            $kategoriProdukOptions[] = $row['kategoriProduk'];
        }

        // Membangun kueri SQL utama secara dinamis
        $query = "SELECT h.id_transaksi, t.jumlahTransaksi, t.usiaAkun, t.metodePembayaran, t.kategoriProduk, h.kategori_prediksi, h.probabilitas_prediksi
                  FROM hasil_klasifikasi h
                  JOIN transaksi t ON h.id_transaksi = t.id_transaksi";

        $where_clauses = [];
        if (!empty($id_to_show)) {
            $where_clauses[] = "h.id_transaksi = '" . mysqli_real_escape_string($koneksi, $id_to_show) . "'";
        }
        if (!empty($kategori_to_show)) {
            $where_clauses[] = "h.kategori_prediksi = '" . mysqli_real_escape_string($koneksi, $kategori_to_show) . "'";
        }
        if (!empty($metode_to_show)) {
            $where_clauses[] = "t.metodePembayaran = '" . mysqli_real_escape_string($koneksi, $metode_to_show) . "'";
        }
        if (!empty($produk_to_show)) {
            $where_clauses[] = "t.kategoriProduk = '" . mysqli_real_escape_string($koneksi, $produk_to_show) . "'";
        }

        if (count($where_clauses) > 0) {
            $query .= " WHERE " . implode(' AND ', $where_clauses);
        }

        // Membangun klausa ORDER BY
        $order_by = '';
        switch ($sort_by) {
            case 'probabilitas':
                $order_by = 'h.probabilitas_prediksi';
                break;
            case 'jumlah_transaksi':
                $order_by = 't.jumlahTransaksi';
                break;
            case 'usia_akun':
                $order_by = 't.usiaAkun';
                break;
            default:
                $order_by = 'h.id_transaksi';
                break;
        }

        $sort_order = strtoupper($sort_order) == 'DESC' ? 'DESC' : 'ASC';
        $query .= " ORDER BY $order_by $sort_order";

        $hasil = $koneksi->query($query);
        ?>
        <main>
            <h2>Hasil Klasifikasi</h2>
            <div class="container-form">
                <form action="hasil.php" method="get">
                    <br>
                    <h3>Filter & Urutan</h3>
                    <div class="form">
                        <div class="form1">

                            <label for="kategori_prediksi">Kategori Prediksi:</label>
                            <br>
                            <select id="kategori_prediksi" name="kategori_prediksi">
                                <option value="">-- Semua --</option>
                                <?php foreach ($kategoriPrediksiOptions as $kategori) : ?>
                                    <option value="<?php echo htmlspecialchars($kategori); ?>" <?php echo ($kategori == $kategori_to_show) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($kategori); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <br>
                            <label for="metode_pembayaran">Metode Pembayaran:</label>
                            <br>
                            <select id="metode_pembayaran" name="metode_pembayaran">
                                <option value="">-- Semua --</option>
                                <?php foreach ($metodePembayaranOptions as $metode) : ?>
                                    <option value="<?php echo htmlspecialchars($metode); ?>" <?php echo ($metode == $metode_to_show) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($metode); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <br>

                            <label for="kategori_produk">Kategori Produk:</label>
                            <br>
                            <select id="kategori_produk" name="kategori_produk">
                                <option value="">-- Semua --</option>
                                <?php foreach ($kategoriProdukOptions as $produk) : ?>
                                    <option value="<?php echo htmlspecialchars($produk); ?>" <?php echo ($produk == $produk_to_show) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($produk); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <br>

                            <label for="sort_by">Urutkan Berdasarkan:</label>
                            <br>
                            <select id="sort_by" name="sort_by">
                                <option value="id_transaksi" <?php echo ($sort_by == 'id_transaksi') ? 'selected' : ''; ?>>ID Transaksi</option>
                                <option value="probabilitas" <?php echo ($sort_by == 'probabilitas') ? 'selected' : ''; ?>>Probabilitas</option>
                                <option value="jumlah_transaksi" <?php echo ($sort_by == 'jumlah_transaksi') ? 'selected' : ''; ?>>Jumlah Transaksi</option>
                                <option value="usia_akun" <?php echo ($sort_by == 'usia_akun') ? 'selected' : ''; ?>>Usia Akun</option>
                            </select>
                            <br>

                            <label for="sort_order">Urutan:</label>
                            <br>
                            <select id="sort_order" name="sort_order">
                                <option value="DESC" <?php echo ($sort_order == 'DESC') ? 'selected' : ''; ?>>Tertinggi ke Terendah</option>
                                <option value="ASC" <?php echo ($sort_order == 'ASC') ? 'selected' : ''; ?>>Terendah ke Tertinggi</option>
                            </select>

                            <br>
                            <div class="bt-form">
                                <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="recent-naive">
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
                            if ($hasil && $hasil->num_rows > 0) {
                                while ($row = mysqli_fetch_array($hasil)) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                                        <td><?php echo "Rp. " . number_format($row['jumlahTransaksi'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($row['usiaAkun']); ?> hari</td>
                                        <td><?php echo htmlspecialchars($row['metodePembayaran']); ?></td>
                                        <td><?php echo htmlspecialchars($row['kategoriProduk']); ?></td>
                                        <td style='font-weight: bold;'><?php echo htmlspecialchars($row['kategori_prediksi']); ?></td>
                                        <td><?php echo round($row['probabilitas_prediksi'] * 100, 2) . "%"; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data yang ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>