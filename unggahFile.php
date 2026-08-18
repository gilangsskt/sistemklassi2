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

if (isset($_POST['submit'])) {
    if (isset($_FILES['file_data'])) {
        $result = tambahDataDariFile($_FILES['file_data']);
        echo "<script>alert('{$result}');</script>";
        echo "  <script>
                    location.href='dataTransaksi.php';
                </script>";
    } else {
        echo "<script>alert('File tidak ditemukan.');</script>";
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
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form">
                        <div class="form1">
                            <label for="file_data">Pilih File Data Transaksi (Hanya Bisa File CSV)</label>
                            <br>
                            <input type="file" id="file_data" name="file_data" required>
                        </div>

                        <div class="bt-form">
                            <button type="submit" name="submit" class="btn btn-primary">Unggah</button>
                            <button type="button" name="cancel" onclick="location.href='dataTransaksi.php'" class="btn btn-primary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>



        </main>
        <!-- end of main -->
    </div>


</body>

</html>