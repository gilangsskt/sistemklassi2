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
$query = mysqli_query($koneksi, "SELECT * FROM kriteria_klasifikasi");


if (isset($_POST['submit'])) {
    $kategori = $_POST['kategori'];
    $conditions = $_POST['conditions'];

    // Panggil fungsi dengan input dari form
    if (tambahKriteriaKlasifikasi($kategori, $conditions) > 0) {
        echo "  <script>
                    alert('Data berhasil ditambahkan');
                    location.href='kriteriaAturan.php';
                </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan');
                location.href='kriteriaAturan.php';
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
            <h2>Form Kriteria Aturan</h2>


            <!-- end of insights -->
            <div class="container-form">
                <form action="" method="post">
                    <div class="form">

                        <div class="form1">
                            <label for="kategori">Kategori Kelas</label>
                            <br>
                            <select id="kategori" name="kategori">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Pembelanja Tinggi">Pembelanja Tinggi</option>
                                <option value="Pembeli Sesekali">Pembeli Sesekali</option>
                                <option value="Pelanggan Baru">Pelanggan Baru</option>
                            </select>
                        </div>
                        <div id="conditions-container">
                            <label>Aturan Kelas:</label>
                            <p>Gunakan operator AND/OR untuk menggabungkan kondisi.</p>
                        </div>
                        <div class="bt-form2">
                            <button type="button" class="btn btn-secondary" id="addConditionBtn">+ Tambah Kondisi</button>
                        </div>
                        <br>
                        <div class="bt-form">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <button type="submit" name="cancel" onclick="location.href='bobot.php'" class="btn btn-primary">Cancel</button>
                        </div>

                        <!-- end of input -->
                    </div>
                </form>
                <!-- end of form -->

                <div class="recent-naive">
                    <h2>Data Kriteria Aturan</h2>
                    <table>
                        <thead>
                            <th>Nama Kategori</th>
                            <th>Aturan</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['nama_kategori'] ?></td>
                                    <td><?php echo $row['aturan_hybrid'] ?></td>
                                    <td class="bt-tabel">
                                        <div class="bt1">
                                            <a href="ubah_kriteria.php?id=<?= $row["id_kriteria"]; ?>">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </a>
                                        </div>
                                        <div class="bt2">
                                            <a href="hapus_kriteria.php?id=<?= $row["id_kriteria"]; ?>">
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
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('conditions-container');
            const addBtn = document.getElementById('addConditionBtn');
            let conditionIndex = 0;

            function addConditionRow() {
                const div = document.createElement('div');
                div.className = 'condition-group';
                div.innerHTML = `
            
            
            <div class="condition-row">
                <div class="form1">
                    <label>Atribut:</label>
                    <br>
                    
                    <select name="conditions[${conditionIndex}][attribute]" required>
                        <option value="">Pilih Atribut</option>
                        <option value="jumlahTransaksi">jumlahTransaksi</option>
                        <option value="usiaAkun">usiaAkun</option>
                        <option value="metodePembayaran">metodePembayaran</option>
                        <option value="kategoriProduk">kategoriProduk</option>
                    </select>
                </div>
                <div class="form1">
                    <label>Operator:</label>
                    <br>
                    <select name="conditions[${conditionIndex}][operator]" required>
                        <option value="" disabled selected>Pilih Operator</option>
                        <option value=">">></option>
                        <option value="<"><</option>
                        <option value=">=">>=</option>
                        <option value="<="><=</option>
                        <option value="==">==</option>
                        <option value="!=">!=</option>
                    </select>
                </div>
                <div class="form1">
                    <label>Nilai:</label>
                    <br>
                    <input type="text" name="conditions[${conditionIndex}][value]" required>
                </div>
                <div class="form1">
                    <label>Logika:</label>
                    <br>
                    <select name="conditions[${conditionIndex}][logic]">
                        <option value="" disabled selected>Logika (Kosongi Saja Jika Tidak ingin Menambah Kondisi)</option>
                        <option value="AND">AND</option>
                        <option value="OR">OR</option>
                    </select>
                </div>
            </div>
            <div class="bt-form3">
            
                <button type="button" class="remove-btn">- Kurangi Kondisi</button>
                
            </div>
            <br>
        `;
                container.appendChild(div);
                conditionIndex++;

                // Tambahkan event listener untuk tombol hapus
                div.querySelector('.remove-btn').addEventListener('click', function() {
                    div.remove();
                });
            }

            addBtn.addEventListener('click', addConditionRow);

            // Tambahkan baris kondisi pertama secara default
            addConditionRow();
        });
    </script>


</body>

</html>