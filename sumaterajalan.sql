-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 05:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sumaterajalan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Gabriel S', 'gabrielganteng', '$2y$10$vgIo.ZJ2yqKndYoU8fbp8.mEzxJTLZEeqZnpKNt6zlmo9qyTsCvyi', '2026-01-30 14:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `budaya`
--

CREATE TABLE `budaya` (
  `id` int(11) NOT NULL,
  `nama_budaya` varchar(255) NOT NULL,
  `asal_provinsi_id` int(11) DEFAULT NULL,
  `kategori_budaya` enum('Tarian','Upacara Adat','Alat Musik','Pakaian Adat','Seni Pertunjukan') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budaya`
--

INSERT INTO `budaya` (`id`, `nama_budaya`, `asal_provinsi_id`, `kategori_budaya`, `deskripsi`, `foto`) VALUES
(1, 'Tari Saman', 1, 'Tarian', 'Tarian harmonisasi ribuan tangan dari Aceh.', '1769182214_tari saman.jpg'),
(2, 'Lompat Batu', 2, 'Upacara Adat', 'Tradisi kedewasaan pemuda Nias.', '1769182182_lompat batu.jpg'),
(3, 'Gordang Sambilan', 2, 'Alat Musik', 'Sembilan gendang sakral Mandailing.', '1769182138_Gordang Sambilan.webp'),
(4, 'Tari Piring', 3, 'Tarian', 'Tarian lincah menggunakan piring dari Minangkabau.', '1769182104_tari piring.png'),
(5, 'Pakaian Aesan Gede', 6, 'Pakaian Adat', 'Busana kebesaran Kerajaan Sriwijaya.', '1769182078_Pakaian Aesan Gede.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `lokasi_id` int(11) DEFAULT NULL,
  `url_foto` varchar(255) NOT NULL,
  `caption` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `ikon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `slug`, `ikon`) VALUES
(1, 'Wisata Alam', 'wisata-alam', NULL),
(2, 'Kuliner', 'kuliner', NULL),
(3, 'Budaya & Sejarah', 'budaya-sejarah', NULL),
(4, 'Tempat Favorit', 'favorit-lokal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kuliner`
--

CREATE TABLE `kuliner` (
  `id` int(11) NOT NULL,
  `nama_kuliner` varchar(100) NOT NULL,
  `asal_provinsi_id` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori_kuliner` enum('Makanan Berat','Camilan','Minuman') DEFAULT 'Makanan Berat',
  `status_halal` enum('Halal','Non-Halal') DEFAULT 'Halal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuliner`
--

INSERT INTO `kuliner` (`id`, `nama_kuliner`, `asal_provinsi_id`, `deskripsi`, `foto`, `kategori_kuliner`, `status_halal`) VALUES
(1, 'Rendang', 3, 'Daging rempah yang dimasak berjam-jam.', '1769182039_rendang.webp', 'Makanan Berat', 'Halal'),
(2, 'Pempek', 6, 'Olahan ikan khas Palembang dengan kuah cuko.', '1769182008_pempek.webp', 'Camilan', 'Halal'),
(3, 'Mie Aceh', 1, 'Mie kaya rempah dengan daging kambing/seafood.', '1769181949_mie aeh.jpg', 'Makanan Berat', 'Halal'),
(4, 'Teh Talua', 3, 'Minuman stamina dari campuran teh dan telur.', '1769181921_teh talua.jfif', 'Minuman', 'Halal'),
(5, 'Bika Ambon', 2, 'Kue legit berongga khas Medan.', '1769181890_bika ambon.jpg', 'Camilan', 'Halal');

-- --------------------------------------------------------

--
-- Table structure for table `kuliner_tempat`
--

CREATE TABLE `kuliner_tempat` (
  `id` int(11) NOT NULL,
  `kuliner_id` int(11) DEFAULT NULL,
  `nama_toko` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `link_maps` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuliner_tempat`
--

INSERT INTO `kuliner_tempat` (`id`, `kuliner_id`, `nama_toko`, `alamat`, `link_maps`) VALUES
(1, 1, 'BPK TESALONIKA', 'Jl. Jamin Ginting No.103, Simpang Selayang, Kec. Medan Tuntungan, Kota Medan, Sumatera Utara 20135', 'https://maps.app.goo.gl/E6AKqDavz95vghZ37');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `provinsi_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `nama_tempat` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto_utama` varchar(255) DEFAULT NULL,
  `link_maps` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `harga_tiket` varchar(50) DEFAULT 'Gratis',
  `jam_operasional` varchar(100) DEFAULT NULL,
  `google_maps_url` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `provinsi_id`, `kategori_id`, `nama_tempat`, `slug`, `deskripsi`, `foto_utama`, `link_maps`, `alamat`, `harga_tiket`, `jam_operasional`, `google_maps_url`, `latitude`, `longitude`, `is_featured`, `created_at`) VALUES
(1, 2, 1, 'Danau Toba', 'danau-toba', 'Danau vulkanik terbesar dengan Pulau Samosir.', '1769181815_danau_toba.webp', 'https://maps.app.goo.gl/3AqLLkwVcWNrz8uu7', NULL, 'Gratis', NULL, NULL, NULL, NULL, 0, '2026-01-23 15:14:11'),
(2, 3, 1, 'Ngarai Sianok', 'ngarai-sianok', 'Ngarai Sianok\r\nNgarai Sianok adalah sebuah lembah curam (jurang) yang indah yang terbentuk akibat aktivitas tektonik lempeng bumi dan terletak di perbatasan Kota Bukittinggi dan Kabupaten Agam, Sumatera Barat. Kawasan ini merupakan objek wisata alam populer yang terkenal dengan pemandangannya yang menakjubkan dan udaranya yang sejuk.', '1769181758_Ngarai_Sianok.jpg', 'https://maps.app.goo.gl/i1rvzG1ac3uY9XX17', NULL, 'Gratis', NULL, NULL, NULL, NULL, 0, '2026-01-23 15:14:11'),
(3, 7, 3, 'Benteng Marlborough', 'benteng-marlborough', 'Benteng Marlborough (Fort Marlborough) adalah benteng peninggalan Inggris di Bengkulu, dibangun tahun 1714-1719 oleh East India Company sebagai pos pertahanan dan perdagangan, kini jadi objek wisata sejarah utama dengan arsitektur unik menyerupai kura-kura dan menyimpan kisah kolonial, tempat edukasi sejarah, serta menikmati pemandangan kota dan Samudra Hindia. ', '1769181674_Benteng_Marlborough.jpeg', 'https://maps.app.goo.gl/9dvwah51icdb8qDq5', NULL, 'Gratis', NULL, NULL, NULL, NULL, 0, '2026-01-23 15:14:11'),
(4, 8, 1, 'Pantai Tanjung Tinggi', 'pantai-tanjung-tinggi', 'Pantai Tanjung Tinggi adalah pantai terkenal di Pulau Belitung, Indonesia, yang memukau dengan pasir putih halus, air biru kehijauan, dan formasi batu granit raksasa, menjadikannya lokasi syuting film \"Laskar Pelangi\" dan tempat ideal untuk berenang, snorkeling, serta menikmati pemandangan alam yang ikonik.', '1769181575_tanjung_tinggi.jpg', 'https://maps.app.goo.gl/U4B6MbHdxXCfoRya8', NULL, 'Gratis', NULL, NULL, NULL, NULL, 0, '2026-01-23 15:14:11'),
(5, 6, 1, 'Gunung Dempo', 'gunung-dempo', 'Gunung Dempo adalah gunung api aktif tipe stratovolcano tertinggi di Sumatera Selatan, terletak di Pagar Alam, terkenal dengan pemandangan kebun teh, kawah berwarna-warni, dan menjadi destinasi wisata favorit serta lokasi olahraga ekstrem seperti paralayang. Gunung ini memiliki ketinggian sekitar 3.173 mdpl dan sering dikunjungi wisatawan untuk menikmati keindahan alam serta budaya lokal, meskipun pendakian ke puncaknya menantang dengan trek terjal dan seringkali ada kabut. ', '1769181489_gunung-dempo.png', 'https://maps.app.goo.gl/R93skGCi6pLpW1xA8', NULL, 'Gratis', NULL, NULL, NULL, NULL, 0, '2026-01-23 15:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `nama_provinsi` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `ibu_kota` varchar(50) DEFAULT NULL,
  `foto_provinsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id`, `nama_provinsi`, `slug`, `ibu_kota`, `foto_provinsi`) VALUES
(1, 'Aceh', 'aceh', 'Banda Aceh', NULL),
(2, 'Sumatera Utara', 'sumatera-utara', 'Medan', NULL),
(3, 'Sumatera Barat', 'sumatera-barat', 'Padang', NULL),
(4, 'Riau', 'riau', 'Pekanbaru', NULL),
(5, 'Kepulauan Riau', 'kepulauan-riau', 'Tanjungpinang', NULL),
(6, 'Jambi', 'jambi', 'Jambi', NULL),
(7, 'Bengkulu', 'bengkulu', 'Bengkulu', NULL),
(8, 'Sumatera Selatan', 'sumatera-selatan', 'Palembang', NULL),
(9, 'Kepulauan Bangka Belitung', 'bangka-belitung', 'Pangkalpinang', NULL),
(10, 'Lampung', 'lampung', 'Bandar Lampung', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `budaya`
--
ALTER TABLE `budaya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asal_provinsi_id` (`asal_provinsi_id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `kuliner`
--
ALTER TABLE `kuliner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asal_provinsi_id` (`asal_provinsi_id`);

--
-- Indexes for table `kuliner_tempat`
--
ALTER TABLE `kuliner_tempat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kuliner` (`kuliner_id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `provinsi_id` (`provinsi_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budaya`
--
ALTER TABLE `budaya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kuliner`
--
ALTER TABLE `kuliner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kuliner_tempat`
--
ALTER TABLE `kuliner_tempat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budaya`
--
ALTER TABLE `budaya`
  ADD CONSTRAINT `budaya_ibfk_1` FOREIGN KEY (`asal_provinsi_id`) REFERENCES `provinsi` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `galeri`
--
ALTER TABLE `galeri`
  ADD CONSTRAINT `galeri_ibfk_1` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kuliner`
--
ALTER TABLE `kuliner`
  ADD CONSTRAINT `kuliner_ibfk_1` FOREIGN KEY (`asal_provinsi_id`) REFERENCES `provinsi` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kuliner_tempat`
--
ALTER TABLE `kuliner_tempat`
  ADD CONSTRAINT `fk_kuliner` FOREIGN KEY (`kuliner_id`) REFERENCES `kuliner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kuliner_tempat_ibfk_1` FOREIGN KEY (`kuliner_id`) REFERENCES `kuliner` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD CONSTRAINT `lokasi_ibfk_1` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lokasi_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
