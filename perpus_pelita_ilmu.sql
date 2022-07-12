-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2022 at 03:27 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `perpus_pelita_ilmu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku`
--

CREATE TABLE IF NOT EXISTS `tb_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `merk_model` varchar(120) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `tahun` year(4) NOT NULL DEFAULT '2000',
  `jumlah` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `merk_model`, `jenis`, `tahun`, `jumlah`) VALUES
(4, 'Meraih Keselamatan dan Kebahagiaan / Din Zainuddin', 'Ilmu Pengetahuan umum', 2000, 2),
(5, 'Keanekaragamaan Biota Laut / Iyam', 'Ilmu Pengetahuan umum', 2006, 1),
(7, 'Membentuk Karakter Yang Cerdas / Saridi Salimin', 'Ilmu Pengetahuan umum', 2011, 59),
(8, 'Jendela Iptek ( Astronomi ) / Dorling Kindersley', 'Ensyclopedia, Kamus, Buku Referensi', 2001, 1),
(9, 'Sejarah dan Budaya / M.Andin', 'Ensyclopedia, Kamus, Buku Referensi', 2011, 9),
(10, 'Guru Profesional Berkarakter / Amka Abdul Aziz', 'Institut, Assosiasi, Musium', 2013, 2),
(11, 'Sufistik : Terpikat Jerat Setan / Tasirun Sulaiman', 'Buku Umum Lain-lain', 2012, 5),
(12, 'Nabi Muhammad SAW ( Teladan Kesuksesan ) / Laili', 'Buku Umum Lain-lain', 2013, 26),
(17, 'Dasar Codeigniter 3', 'Teknologi', 2017, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman`
--

CREATE TABLE IF NOT EXISTS `tb_peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `nama_peminjam` varchar(50) NOT NULL DEFAULT '0',
  `lp` varchar(50) NOT NULL DEFAULT '',
  `kelas` varchar(50) NOT NULL DEFAULT '0',
  `jenis_peminjaman` tinyint(4) NOT NULL DEFAULT '0',
  `tgl_pinjam` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tgl_kembali` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_peminjaman`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `nama_peminjam`, `lp`, `kelas`, `jenis_peminjaman`, `tgl_pinjam`, `tgl_kembali`) VALUES
(27, 'Yani', 'Laki-Laki', 'Guru/Pegawai', 1, '2022-06-18 10:18:17', '2022-06-18 23:59:59'),
(28, 'Hafidz', 'Laki-Laki', '8D', 1, '2022-06-18 10:23:02', '2022-06-18 23:59:59'),
(29, 'Utuh Tester', 'Laki-Laki', 'Guru/Pegawai', 2, '2022-06-19 03:07:53', '2022-06-26 23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman_buku`
--

CREATE TABLE IF NOT EXISTS `tb_peminjaman_buku` (
  `id_peminjaman` int(11) DEFAULT '0',
  `id_buku` int(11) DEFAULT '0',
  `jumlah` int(11) DEFAULT '0',
  `stts_kembali` tinyint(4) DEFAULT NULL,
  `waktu_kembali` datetime DEFAULT NULL,
  KEY `FK_tb_peminjaman_buku_tb_buku` (`id_buku`),
  KEY `FK_tb_peminjaman_buku_tb_peminjaman` (`id_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_peminjaman_buku`
--

INSERT INTO `tb_peminjaman_buku` (`id_peminjaman`, `id_buku`, `jumlah`, `stts_kembali`, `waktu_kembali`) VALUES
(27, 7, 1, 1, '2022-06-18 16:20:24'),
(27, 12, 1, 1, '2022-06-18 16:20:41'),
(27, 4, 1, 1, '2022-06-18 16:20:22'),
(27, 9, 1, 1, '2022-07-18 23:59:59'),
(28, 10, 1, 1, '2022-06-18 16:23:53'),
(28, 8, 1, 1, '2022-06-18 16:23:55'),
(29, 17, 1, 0, NULL),
(29, 11, 1, 0, NULL),
(29, 9, 2, 0, NULL),
(29, 5, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `role_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `role_id`) VALUES
(1, 'ADMIN', '135', 1),
(2, 'petugas_perpus', '12345678', 2),
(3, 'anu', 'anu', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_peminjaman_buku`
--
ALTER TABLE `tb_peminjaman_buku`
  ADD CONSTRAINT `FK_tb_peminjaman_buku_tb_buku` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tb_peminjaman_buku_tb_peminjaman` FOREIGN KEY (`id_peminjaman`) REFERENCES `tb_peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
