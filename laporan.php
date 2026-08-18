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
?>

<body>

    <div class="container">
        <?php
        include "sidebar.php";
        ?>
        <main>
            <h2>Form Cetak Laporan</h2>
            <div class="laporan">
                <div class="card-1">
                    <a href="cetakDataTransaksi.php">
                        <span class="material-symbols-outlined">
                            credit_card
                        </span>
                    </a>
                    <div class="middle">
                        <div class="left">
                            <h3>Data Transaksi</h3>
                        </div>
                    </div>
                </div>
                <!-- end of card-1 -->

                <div class="card-2">
                    <a href="cetakDataKriteria.php">
                        <span class="material-symbols-outlined">
                            book_5
                        </span>
                    </a>
                    <div class="middle">
                        <div class="left">
                            <h3>Data Kriteria Kelas</h3>
                        </div>
                    </div>
                </div>
                <!-- end of card-2 -->
                <div class="card-3">
                    <a href="cetakDataPrior.php">

                        <span class="material-symbols-outlined">
                            bar_chart
                        </span>
                    </a>
                    <div class="middle">
                        <div class="left">
                            <h3>Data Probabilitas Prior</h3>
                        </div>
                    </div>
                </div>
                <!-- end of card-3 -->
                <div class="card-4">
                    <a href="cetakDataHasil.php">
                        <span class="material-symbols-outlined">
                            analytics
                        </span>
                    </a>
                    <div class="middle">
                        <div class="left">
                            <h3>Data Hasil Klasifikasi</h3>
                        </div>
                    </div>
                </div>
                <!-- end of card-4 -->
            </div>
            <!-- end of container-form -->
        </main>
        <!-- end of main -->
    </div>
</body>

</html>