<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Klasifikasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="./styles/style.css">


</head>
<?php
include "includes/config.php";
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria_klasifikasi WHERE id_kriteria= $id");
$getRow = mysqli_fetch_array($kriteria);



if (isset($_POST["submit"])) {


    if (ubah_kriteria($_POST) > 0) {
        echo "  <script>
                    alert('data berhasil di ubah');
                    location.href='kriteriaAturan.php';
                </script>";
    } else {
        echo "  <script>
                    alert('data gagal di ubah');
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
            <h2>Form Data Bobot</h2>
            <!-- end of insights -->
            <div class="container-form">
                <form action="" method="post">
                    <div class="form">

                        <div class="form1">
                            <div class="form1">
                                <input type="hidden" name="id" value="<?= $getRow["id_kriteria"] ?>">
                            </div>
                        </div>

                        <div class="form1">
                            <label for="f1">Nama Kategori</label>
                            <br>
                            <input type="text" id="f1" name="nama_kategori" value="<?= $getRow["nama_kategori"] ?>">
                        </div>
                        <div class="form1">
                            <label for="f2">Aturan Kelas</label>
                            <br>
                            <input type="text" id="f2" name="aturan_hybrid" value="<?= $getRow["aturan_hybrid"]  ?>">
                        </div>
                        <div class="alert">
                            <span class="material-symbols-outlined">
                                info
                            </span>
                            <p>Anda Sedang Mengubah Data!!</p>
                        </div>


                        <div class="bt-form">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <button type="submit" name="cancel" onclick="event.preventDefault(); window.location.href='kriteriaAturan.php';" class="btn btn-primary">Cancel</button>
                        </div>

                        <!-- end of input -->
                    </div>
                </form>
            </div>



        </main>
        <!-- end of main -->
    </div>


</body>

</html>