-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2025 at 11:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klasifikasi_pelanggan`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_klasifikasi`
--

CREATE TABLE `hasil_klasifikasi` (
  `id_hasil` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `kategori_prediksi` varchar(50) NOT NULL,
  `probabilitas_prediksi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_klasifikasi`
--

INSERT INTO `hasil_klasifikasi` (`id_hasil`, `id_transaksi`, `kategori_prediksi`, `probabilitas_prediksi`) VALUES
(1, 1, 'Pelanggan Baru', 0.9514402413305213),
(2, 2, 'Pembelanja Tinggi', 0.6543678577560715),
(3, 3, 'Pelanggan Baru', 0.8154113663402581),
(4, 4, 'Pembeli Sesekali', 0.8129980586553793),
(5, 5, 'Pembelanja Tinggi', 0.9384462695050789),
(6, 6, 'Pembelanja Tinggi', 0.9384462695050789),
(7, 7, 'Pembeli Sesekali', 0.6254185981896087),
(8, 8, 'Pelanggan Baru', 0.9302352559045984),
(9, 9, 'Pelanggan Baru', 0.5010684962321449),
(10, 10, 'Pelanggan Baru', 0.9302352559045984),
(11, 11, 'Pembelanja Tinggi', 0.9064068828786214),
(12, 12, 'Pelanggan Baru', 0.8802028451001054),
(13, 13, 'Pembelanja Tinggi', 0.8946456890075952);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_klasifikasi`
--

CREATE TABLE `kriteria_klasifikasi` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `aturan_hybrid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria_klasifikasi`
--

INSERT INTO `kriteria_klasifikasi` (`id_kriteria`, `nama_kategori`, `aturan_hybrid`) VALUES
(1, 'Pembelanja Tinggi', 'jumlahTransaksi &gt; 10000000 OR (jumlahTransaksi &gt; 5000000 AND usiaAkun &gt; 180)'),
(2, 'Pembeli Sesekali', '(jumlahTransaksi &lt;= 5000000 AND usiaAkun &gt; 180)'),
(3, 'Pelanggan Baru', '(usiaAkun &lt;= 180 AND jumlahTransaksi &lt;= 10000000)');

-- --------------------------------------------------------

--
-- Table structure for table `probabilitas_likelihood`
--

CREATE TABLE `probabilitas_likelihood` (
  `id_transaksi` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `atribut` varchar(255) NOT NULL,
  `nilai_atribut` varchar(255) NOT NULL,
  `probabilitas` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `probabilitas_likelihood`
--

INSERT INTO `probabilitas_likelihood` (`id_transaksi`, `kategori`, `atribut`, `nilai_atribut`, `probabilitas`) VALUES
(1, 'Pelanggan Baru', 'amount', 'Low', 0.5),
(1, 'Pelanggan Baru', 'kategoriProduk', 'Kosmetik', 0.4),
(1, 'Pelanggan Baru', 'metodePembayaran', 'E-Wallet', 0.5),
(1, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(1, 'Pembelanja Tinggi', 'amount', 'Low', 0.1111111111111111),
(1, 'Pembelanja Tinggi', 'kategoriProduk', 'Kosmetik', 0.18181818181818182),
(1, 'Pembelanja Tinggi', 'metodePembayaran', 'E-Wallet', 0.3333333333333333),
(1, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(1, 'Pembeli Sesekali', 'amount', 'Low', 0.4),
(1, 'Pembeli Sesekali', 'kategoriProduk', 'Kosmetik', 0.14285714285714285),
(1, 'Pembeli Sesekali', 'metodePembayaran', 'E-Wallet', 0.2),
(1, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(2, 'Pelanggan Baru', 'amount', 'High', 0.125),
(2, 'Pelanggan Baru', 'kategoriProduk', 'Elektronik', 0.2),
(2, 'Pelanggan Baru', 'metodePembayaran', 'QRIS', 0.375),
(2, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(2, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(2, 'Pembelanja Tinggi', 'kategoriProduk', 'Elektronik', 0.2727272727272727),
(2, 'Pembelanja Tinggi', 'metodePembayaran', 'QRIS', 0.2222222222222222),
(2, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(2, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(2, 'Pembeli Sesekali', 'kategoriProduk', 'Elektronik', 0.2857142857142857),
(2, 'Pembeli Sesekali', 'metodePembayaran', 'QRIS', 0.4),
(2, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(3, 'Pelanggan Baru', 'amount', 'Medium', 0.375),
(3, 'Pelanggan Baru', 'kategoriProduk', 'Elektronik', 0.2),
(3, 'Pelanggan Baru', 'metodePembayaran', 'E-Wallet', 0.5),
(3, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(3, 'Pembelanja Tinggi', 'amount', 'Medium', 0.1111111111111111),
(3, 'Pembelanja Tinggi', 'kategoriProduk', 'Elektronik', 0.2727272727272727),
(3, 'Pembelanja Tinggi', 'metodePembayaran', 'E-Wallet', 0.3333333333333333),
(3, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(3, 'Pembeli Sesekali', 'amount', 'Medium', 0.4),
(3, 'Pembeli Sesekali', 'kategoriProduk', 'Elektronik', 0.2857142857142857),
(3, 'Pembeli Sesekali', 'metodePembayaran', 'E-Wallet', 0.2),
(3, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(4, 'Pelanggan Baru', 'amount', 'Medium', 0.375),
(4, 'Pelanggan Baru', 'kategoriProduk', 'Olahraga', 0.1),
(4, 'Pelanggan Baru', 'metodePembayaran', 'Kartu Kredit', 0.125),
(4, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(4, 'Pembelanja Tinggi', 'amount', 'Medium', 0.1111111111111111),
(4, 'Pembelanja Tinggi', 'kategoriProduk', 'Olahraga', 0.09090909090909091),
(4, 'Pembelanja Tinggi', 'metodePembayaran', 'Kartu Kredit', 0.4444444444444444),
(4, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(4, 'Pembeli Sesekali', 'amount', 'Medium', 0.4),
(4, 'Pembeli Sesekali', 'kategoriProduk', 'Olahraga', 0.2857142857142857),
(4, 'Pembeli Sesekali', 'metodePembayaran', 'Kartu Kredit', 0.4),
(4, 'Pembeli Sesekali', 'usia', '>180', 0.75),
(5, 'Pelanggan Baru', 'amount', 'High', 0.125),
(5, 'Pelanggan Baru', 'kategoriProduk', 'Pakaian', 0.1),
(5, 'Pelanggan Baru', 'metodePembayaran', 'Kartu Kredit', 0.125),
(5, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(5, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(5, 'Pembelanja Tinggi', 'kategoriProduk', 'Pakaian', 0.2727272727272727),
(5, 'Pembelanja Tinggi', 'metodePembayaran', 'Kartu Kredit', 0.4444444444444444),
(5, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(5, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(5, 'Pembeli Sesekali', 'kategoriProduk', 'Pakaian', 0.14285714285714285),
(5, 'Pembeli Sesekali', 'metodePembayaran', 'Kartu Kredit', 0.4),
(5, 'Pembeli Sesekali', 'usia', '>180', 0.75),
(6, 'Pelanggan Baru', 'amount', 'High', 0.125),
(6, 'Pelanggan Baru', 'kategoriProduk', 'Pakaian', 0.1),
(6, 'Pelanggan Baru', 'metodePembayaran', 'Kartu Kredit', 0.125),
(6, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(6, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(6, 'Pembelanja Tinggi', 'kategoriProduk', 'Pakaian', 0.2727272727272727),
(6, 'Pembelanja Tinggi', 'metodePembayaran', 'Kartu Kredit', 0.4444444444444444),
(6, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(6, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(6, 'Pembeli Sesekali', 'kategoriProduk', 'Pakaian', 0.14285714285714285),
(6, 'Pembeli Sesekali', 'metodePembayaran', 'Kartu Kredit', 0.4),
(6, 'Pembeli Sesekali', 'usia', '>180', 0.75),
(7, 'Pelanggan Baru', 'amount', 'Low', 0.5),
(7, 'Pelanggan Baru', 'kategoriProduk', 'Elektronik', 0.2),
(7, 'Pelanggan Baru', 'metodePembayaran', 'QRIS', 0.375),
(7, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(7, 'Pembelanja Tinggi', 'amount', 'Low', 0.1111111111111111),
(7, 'Pembelanja Tinggi', 'kategoriProduk', 'Elektronik', 0.2727272727272727),
(7, 'Pembelanja Tinggi', 'metodePembayaran', 'QRIS', 0.2222222222222222),
(7, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(7, 'Pembeli Sesekali', 'amount', 'Low', 0.4),
(7, 'Pembeli Sesekali', 'kategoriProduk', 'Elektronik', 0.2857142857142857),
(7, 'Pembeli Sesekali', 'metodePembayaran', 'QRIS', 0.4),
(7, 'Pembeli Sesekali', 'usia', '>180', 0.75),
(8, 'Pelanggan Baru', 'amount', 'Low', 0.5),
(8, 'Pelanggan Baru', 'kategoriProduk', 'Kosmetik', 0.4),
(8, 'Pelanggan Baru', 'metodePembayaran', 'QRIS', 0.375),
(8, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(8, 'Pembelanja Tinggi', 'amount', 'Low', 0.1111111111111111),
(8, 'Pembelanja Tinggi', 'kategoriProduk', 'Kosmetik', 0.18181818181818182),
(8, 'Pembelanja Tinggi', 'metodePembayaran', 'QRIS', 0.2222222222222222),
(8, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(8, 'Pembeli Sesekali', 'amount', 'Low', 0.4),
(8, 'Pembeli Sesekali', 'kategoriProduk', 'Kosmetik', 0.14285714285714285),
(8, 'Pembeli Sesekali', 'metodePembayaran', 'QRIS', 0.4),
(8, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(9, 'Pelanggan Baru', 'amount', 'High', 0.125),
(9, 'Pelanggan Baru', 'kategoriProduk', 'Kosmetik', 0.4),
(9, 'Pelanggan Baru', 'metodePembayaran', 'E-Wallet', 0.5),
(9, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(9, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(9, 'Pembelanja Tinggi', 'kategoriProduk', 'Kosmetik', 0.18181818181818182),
(9, 'Pembelanja Tinggi', 'metodePembayaran', 'E-Wallet', 0.3333333333333333),
(9, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(9, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(9, 'Pembeli Sesekali', 'kategoriProduk', 'Kosmetik', 0.14285714285714285),
(9, 'Pembeli Sesekali', 'metodePembayaran', 'E-Wallet', 0.2),
(9, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(10, 'Pelanggan Baru', 'amount', 'Low', 0.5),
(10, 'Pelanggan Baru', 'kategoriProduk', 'Kosmetik', 0.4),
(10, 'Pelanggan Baru', 'metodePembayaran', 'QRIS', 0.375),
(10, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(10, 'Pembelanja Tinggi', 'amount', 'Low', 0.1111111111111111),
(10, 'Pembelanja Tinggi', 'kategoriProduk', 'Kosmetik', 0.18181818181818182),
(10, 'Pembelanja Tinggi', 'metodePembayaran', 'QRIS', 0.2222222222222222),
(10, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(10, 'Pembeli Sesekali', 'amount', 'Low', 0.4),
(10, 'Pembeli Sesekali', 'kategoriProduk', 'Kosmetik', 0.14285714285714285),
(10, 'Pembeli Sesekali', 'metodePembayaran', 'QRIS', 0.4),
(10, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(11, 'Pelanggan Baru', 'amount', 'High', 0.125),
(11, 'Pelanggan Baru', 'kategoriProduk', 'Travel', 0.2),
(11, 'Pelanggan Baru', 'metodePembayaran', 'Kartu Kredit', 0.125),
(11, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(11, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(11, 'Pembelanja Tinggi', 'kategoriProduk', 'Travel', 0.18181818181818182),
(11, 'Pembelanja Tinggi', 'metodePembayaran', 'Kartu Kredit', 0.4444444444444444),
(11, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(11, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(11, 'Pembeli Sesekali', 'kategoriProduk', 'Travel', 0.14285714285714285),
(11, 'Pembeli Sesekali', 'metodePembayaran', 'Kartu Kredit', 0.4),
(11, 'Pembeli Sesekali', 'usia', '>180', 0.75),
(12, 'Pelanggan Baru', 'amount', 'Medium', 0.375),
(12, 'Pelanggan Baru', 'kategoriProduk', 'Travel', 0.2),
(12, 'Pelanggan Baru', 'metodePembayaran', 'E-Wallet', 0.5),
(12, 'Pelanggan Baru', 'usia', '<=180', 0.8571428571428571),
(12, 'Pembelanja Tinggi', 'amount', 'Medium', 0.1111111111111111),
(12, 'Pembelanja Tinggi', 'kategoriProduk', 'Travel', 0.18181818181818182),
(12, 'Pembelanja Tinggi', 'metodePembayaran', 'E-Wallet', 0.3333333333333333),
(12, 'Pembelanja Tinggi', 'usia', '<=180', 0.375),
(12, 'Pembeli Sesekali', 'amount', 'Medium', 0.4),
(12, 'Pembeli Sesekali', 'kategoriProduk', 'Travel', 0.14285714285714285),
(12, 'Pembeli Sesekali', 'metodePembayaran', 'E-Wallet', 0.2),
(12, 'Pembeli Sesekali', 'usia', '<=180', 0.25),
(13, 'Pelanggan Baru', 'amount', 'High', 0.125),
(13, 'Pelanggan Baru', 'kategoriProduk', 'Elektronik', 0.2),
(13, 'Pelanggan Baru', 'metodePembayaran', 'E-Wallet', 0.5),
(13, 'Pelanggan Baru', 'usia', '>180', 0.14285714285714285),
(13, 'Pembelanja Tinggi', 'amount', 'High', 0.7777777777777778),
(13, 'Pembelanja Tinggi', 'kategoriProduk', 'Elektronik', 0.2727272727272727),
(13, 'Pembelanja Tinggi', 'metodePembayaran', 'E-Wallet', 0.3333333333333333),
(13, 'Pembelanja Tinggi', 'usia', '>180', 0.625),
(13, 'Pembeli Sesekali', 'amount', 'High', 0.2),
(13, 'Pembeli Sesekali', 'kategoriProduk', 'Elektronik', 0.2857142857142857),
(13, 'Pembeli Sesekali', 'metodePembayaran', 'E-Wallet', 0.2),
(13, 'Pembeli Sesekali', 'usia', '>180', 0.75);

-- --------------------------------------------------------

--
-- Table structure for table `probabilitas_posterior`
--

CREATE TABLE `probabilitas_posterior` (
  `id_posterior` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `probabilitas` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `probabilitas_posterior`
--

INSERT INTO `probabilitas_posterior` (`id_posterior`, `id_transaksi`, `kategori`, `probabilitas`) VALUES
(1, 1, 'Pembelanja Tinggi', 0.03270242131396993),
(2, 1, 'Pembeli Sesekali', 0.01585733735550869),
(3, 1, 'Pelanggan Baru', 0.9514402413305213),
(4, 2, 'Pembelanja Tinggi', 0.6543678577560715),
(5, 2, 'Pembeli Sesekali', 0.09065761108037472),
(6, 2, 'Pelanggan Baru', 0.25497453116355384),
(7, 3, 'Pembelanja Tinggi', 0.11210762331838563),
(8, 3, 'Pembeli Sesekali', 0.07248101034135629),
(9, 3, 'Pelanggan Baru', 0.8154113663402581),
(10, 4, 'Pembelanja Tinggi', 0.15524420467839495),
(11, 4, 'Pembeli Sesekali', 0.8129980586553793),
(12, 4, 'Pelanggan Baru', 0.03175773666622575),
(13, 5, 'Pembelanja Tinggi', 0.9384462695050789),
(14, 5, 'Pembeli Sesekali', 0.0585065161139843),
(15, 5, 'Pelanggan Baru', 0.0030472143809366823),
(16, 6, 'Pembelanja Tinggi', 0.9384462695050789),
(17, 6, 'Pembeli Sesekali', 0.0585065161139843),
(18, 6, 'Pelanggan Baru', 0.0030472143809366823),
(19, 7, 'Pembelanja Tinggi', 0.17913808987613875),
(20, 7, 'Pembeli Sesekali', 0.6254185981896087),
(21, 7, 'Pelanggan Baru', 0.19544331193425263),
(22, 8, 'Pembelanja Tinggi', 0.02842095494408612),
(23, 8, 'Pembeli Sesekali', 0.0413437891513155),
(24, 8, 'Pelanggan Baru', 0.9302352559045984),
(25, 9, 'Pembelanja Tinggi', 0.4822292205601169),
(26, 9, 'Pembeli Sesekali', 0.016702283207738165),
(27, 9, 'Pelanggan Baru', 0.5010684962321449),
(28, 10, 'Pembelanja Tinggi', 0.02842095494408612),
(29, 10, 'Pembeli Sesekali', 0.0413437891513155),
(30, 10, 'Pelanggan Baru', 0.9302352559045984),
(31, 11, 'Pembelanja Tinggi', 0.9064068828786214),
(32, 11, 'Pembeli Sesekali', 0.08476357777030516),
(33, 11, 'Pelanggan Baru', 0.008829539351073452),
(34, 12, 'Pembelanja Tinggi', 0.08067702845100104),
(35, 12, 'Pembeli Sesekali', 0.03912012644889358),
(36, 12, 'Pelanggan Baru', 0.8802028451001054),
(37, 13, 'Pembelanja Tinggi', 0.8946456890075952),
(38, 13, 'Pembeli Sesekali', 0.07436774893581506),
(39, 13, 'Pelanggan Baru', 0.030986562056589603);

-- --------------------------------------------------------

--
-- Table structure for table `probabilitas_prior`
--

CREATE TABLE `probabilitas_prior` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `probabilitas` double NOT NULL,
  `dihitung_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `probabilitas_prior`
--

INSERT INTO `probabilitas_prior` (`id`, `kategori`, `probabilitas`, `dihitung_pada`) VALUES
(1, 'Pembelanja Tinggi', 0.4375, '2025-08-24 10:32:55'),
(2, 'Pembeli Sesekali', 0.1875, '2025-08-24 10:32:55'),
(3, 'Pelanggan Baru', 0.375, '2025-08-24 10:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kategoriProduk` varchar(50) DEFAULT NULL,
  `jumlahTransaksi` decimal(18,2) NOT NULL,
  `metodePembayaran` varchar(50) DEFAULT NULL,
  `jumlahBarang` int(11) NOT NULL,
  `tipePerangkat` varchar(50) DEFAULT NULL,
  `tanggalTransaksi` datetime NOT NULL,
  `usiaPengguna` int(11) NOT NULL,
  `usiaAkun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kategoriProduk`, `jumlahTransaksi`, `metodePembayaran`, `jumlahBarang`, `tipePerangkat`, `tanggalTransaksi`, `usiaPengguna`, `usiaAkun`) VALUES
(1, 'Kosmetik', 1307370.00, 'E-Wallet', 5, 'Tablet', '2025-06-02 00:00:00', 59, 31),
(2, 'Elektronik', 11643050.00, 'QRIS', 8, 'Mobile', '2025-04-16 00:00:00', 27, 128),
(3, 'Elektronik', 2007010.00, 'E-Wallet', 1, 'Desktop', '2025-04-14 00:00:00', 30, 15),
(4, 'Olahraga', 4796810.00, 'Kartu Kredit', 5, 'Desktop', '2025-06-30 00:00:00', 18, 324),
(5, 'Pakaian', 5992900.00, 'Kartu Kredit', 8, 'Mobile', '2025-04-08 00:00:00', 12, 311),
(6, 'Pakaian', 8214460.00, 'Kartu Kredit', 7, 'Desktop', '2025-04-04 00:00:00', 11, 262),
(7, 'Elektronik', 1221820.00, 'QRIS', 10, 'Mobile', '2025-05-03 00:00:00', 14, 353),
(8, 'Kosmetik', 1864980.00, 'QRIS', 10, 'Mobile', '2025-03-05 00:00:00', 61, 2),
(9, 'Kosmetik', 11248340.00, 'E-Wallet', 10, 'Mobile', '2025-03-14 00:00:00', 53, 112),
(10, 'Kosmetik', 206790.00, 'QRIS', 6, 'Mobile', '2025-04-16 00:00:00', 64, 152),
(11, 'Travel', 8986550.00, 'Kartu Kredit', 1, 'Mobile', '2025-01-25 00:00:00', 64, 260),
(12, 'Travel', 2240710.00, 'E-Wallet', 6, 'Desktop', '2025-03-07 00:00:00', 50, 148),
(13, 'Elektronik', 6442730.00, 'E-Wallet', 4, 'Tablet', '2025-01-24 00:00:00', 15, 209);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_terlabel`
--

CREATE TABLE `transaksi_terlabel` (
  `id_transaksi` int(11) NOT NULL,
  `jumlahTransaksi` decimal(10,2) NOT NULL,
  `usiaAkun` int(11) NOT NULL,
  `metodePembayaran` varchar(50) NOT NULL,
  `kategoriProduk` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_terlabel`
--

INSERT INTO `transaksi_terlabel` (`id_transaksi`, `jumlahTransaksi`, `usiaAkun`, `metodePembayaran`, `kategoriProduk`, `kelas`) VALUES
(1, 1307370.00, 31, 'E-Wallet', 'Kosmetik', 'Pelanggan Baru'),
(2, 11643050.00, 128, 'QRIS', 'Elektronik', 'Pembelanja Tinggi'),
(3, 2007010.00, 15, 'E-Wallet', 'Elektronik', 'Pelanggan Baru'),
(4, 4796810.00, 324, 'Kartu Kredit', 'Olahraga', 'Pembeli Sesekali'),
(5, 5992900.00, 311, 'Kartu Kredit', 'Pakaian', 'Pembelanja Tinggi'),
(6, 8214460.00, 262, 'Kartu Kredit', 'Pakaian', 'Pembelanja Tinggi'),
(7, 1221820.00, 353, 'QRIS', 'Elektronik', 'Pembeli Sesekali'),
(8, 1864980.00, 2, 'QRIS', 'Kosmetik', 'Pelanggan Baru'),
(9, 11248340.00, 112, 'E-Wallet', 'Kosmetik', 'Pembelanja Tinggi'),
(10, 206790.00, 152, 'QRIS', 'Kosmetik', 'Pelanggan Baru'),
(11, 8986550.00, 260, 'Kartu Kredit', 'Travel', 'Pembelanja Tinggi'),
(12, 2240710.00, 148, 'E-Wallet', 'Travel', 'Pelanggan Baru'),
(13, 6442730.00, 209, 'E-Wallet', 'Elektronik', 'Pembelanja Tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_klasifikasi`
--
ALTER TABLE `hasil_klasifikasi`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `kriteria_klasifikasi`
--
ALTER TABLE `kriteria_klasifikasi`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `probabilitas_likelihood`
--
ALTER TABLE `probabilitas_likelihood`
  ADD PRIMARY KEY (`id_transaksi`,`kategori`,`atribut`);

--
-- Indexes for table `probabilitas_posterior`
--
ALTER TABLE `probabilitas_posterior`
  ADD PRIMARY KEY (`id_posterior`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`,`kategori`);

--
-- Indexes for table `probabilitas_prior`
--
ALTER TABLE `probabilitas_prior`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori` (`kategori`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_terlabel`
--
ALTER TABLE `transaksi_terlabel`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_klasifikasi`
--
ALTER TABLE `hasil_klasifikasi`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kriteria_klasifikasi`
--
ALTER TABLE `kriteria_klasifikasi`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `probabilitas_posterior`
--
ALTER TABLE `probabilitas_posterior`
  MODIFY `id_posterior` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `probabilitas_prior`
--
ALTER TABLE `probabilitas_prior`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_klasifikasi`
--
ALTER TABLE `hasil_klasifikasi`
  ADD CONSTRAINT `hasil_klasifikasi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `probabilitas_posterior`
--
ALTER TABLE `probabilitas_posterior`
  ADD CONSTRAINT `probabilitas_posterior_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_terlabel`
--
ALTER TABLE `transaksi_terlabel`
  ADD CONSTRAINT `transaksi_terlabel_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
