-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.8-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table simkemawa.kegiatan
CREATE TABLE IF NOT EXISTS `kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruangan_id` varchar(200) DEFAULT NULL,
  `ormawa_id` varchar(200) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_akhir` time DEFAULT NULL,
  `total_biaya_kegiatan` int(11) DEFAULT NULL,
  `biaya_keikutsertaan` int(11) DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL,
  `jml_peserta` int(11) NOT NULL DEFAULT 0,
  `jml_kehadiran` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.kegiatan: ~2 rows (approximately)
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
INSERT INTO `kegiatan` (`id`, `ruangan_id`, `ormawa_id`, `nama`, `poster`, `tanggal`, `deskripsi`, `waktu_mulai`, `waktu_akhir`, `total_biaya_kegiatan`, `biaya_keikutsertaan`, `kuota`, `jml_peserta`, `jml_kehadiran`, `status`, `created_at`, `updated_at`) VALUES
	(6, '1', '18', 'Pentas Seni', '1609055879.png', '2020-12-31', NULL, '12:00:00', '16:00:00', 1000000, 10000, 100, 0, 10, 2, NULL, NULL),
	(7, '3', '18', 'Seminar', '1609772357.png', '2021-01-04', NULL, '12:00:00', '17:00:00', 10000000, 20000, 100, 0, 0, 1, NULL, NULL);
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;

-- Dumping structure for table simkemawa.kegiatan_laporan
CREATE TABLE IF NOT EXISTS `kegiatan_laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan_id` int(11) DEFAULT NULL,
  `dokumentasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.kegiatan_laporan: ~0 rows (approximately)
/*!40000 ALTER TABLE `kegiatan_laporan` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan_laporan` ENABLE KEYS */;

-- Dumping structure for table simkemawa.kegiatan_pendaftar
CREATE TABLE IF NOT EXISTS `kegiatan_pendaftar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `prodi_id` int(11) DEFAULT NULL,
  `angkatan` varchar(50) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.kegiatan_pendaftar: ~0 rows (approximately)
/*!40000 ALTER TABLE `kegiatan_pendaftar` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan_pendaftar` ENABLE KEYS */;

-- Dumping structure for table simkemawa.mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `angkatan` varchar(100) DEFAULT NULL,
  `prodi_id` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `pengguna_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table simkemawa.mahasiswa: ~4 rows (approximately)
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `angkatan`, `prodi_id`, `foto`, `pengguna_id`) VALUES
	(1, '123123123', 'Rahmat', '2020', 'Teknik Informatika', NULL, NULL),
	(2, '1234', 'riris', '2020', '1', NULL, 9),
	(3, '1234', 'riris', '2020', '1', NULL, 10),
	(4, '123', 'Testt', '2020', '1', NULL, 11);
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;

-- Dumping structure for table simkemawa.ormawa
CREATE TABLE IF NOT EXISTS `ormawa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_hp` varchar(150) NOT NULL,
  `nama_ketua` varchar(200) DEFAULT NULL,
  `foto` varchar(220) DEFAULT NULL,
  `pengguna_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.ormawa: ~1 rows (approximately)
/*!40000 ALTER TABLE `ormawa` DISABLE KEYS */;
INSERT INTO `ormawa` (`id`, `nama`, `username`, `password`, `no_hp`, `nama_ketua`, `foto`, `pengguna_id`, `status`) VALUES
	(21, 'robotika', 'robotika', '$2y$10$ie9sGbC7W74P9uqAUpH0P.y8PRs94MqiBDROQDajhtK2jM.CJVNGa', '0812341234213', NULL, NULL, 15, 1);
/*!40000 ALTER TABLE `ormawa` ENABLE KEYS */;

-- Dumping structure for table simkemawa.ormawa_ketua
CREATE TABLE IF NOT EXISTS `ormawa_ketua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ormawa_id` int(11) DEFAULT NULL,
  `nama_ketua` varchar(100) DEFAULT NULL,
  `periode` varchar(200) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.ormawa_ketua: ~1 rows (approximately)
/*!40000 ALTER TABLE `ormawa_ketua` DISABLE KEYS */;
INSERT INTO `ormawa_ketua` (`id`, `ormawa_id`, `nama_ketua`, `periode`, `status`) VALUES
	(2, 21, 'Pak Ketua kijgjkg', '2018-2019', 1);
/*!40000 ALTER TABLE `ormawa_ketua` ENABLE KEYS */;

-- Dumping structure for table simkemawa.pengguna
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `hak_akses` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.pengguna: ~10 rows (approximately)
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` (`id`, `name`, `username`, `password`, `hak_akses`, `created_at`) VALUES
	(1, 'Admin', 'admin', '$2y$10$q3ZikvqztvgouS8b9iulc.f9nRdx5rRHBLo7RLyUGCdiK2NPRSUpa', 'admin', '2020-09-20 17:02:34'),
	(3, 'Wadir III', 'wadir', '$2y$10$xFuuGK6wqyLD..vnEv04uOGgwkkXx.4F8vPn2O2v3eGpvTR.rHtHi', 'wadir', NULL),
	(7, 'Nama Ormawas', 'ormawa', '$2y$10$Nuuq0HQF.Y9Yg./PIjQkl.hrhmV3mNYwVgEJTC57RFFjFQIW0tZ.y', 'ormawa', NULL),
	(8, 'riris', '1234', '$2y$10$Y11KQI1Xw/vf/AZ/VFbYBOJaiq53jXZGMD5sFyLIdWnHu5moCozgS', 'mahasiswa', NULL),
	(9, 'riris', '1234', '$2y$10$3V/.FlHevnapxUSHgNZEKOl/WybfoKzHIciMvSCGdomasOE9WJoIS', 'mahasiswa', NULL),
	(10, 'riris', '1234', '$2y$10$qGz0U.dgIrDKBMhfKDyWAuMiCb5gokp1qMZP4NCH/BkI50cGYub5q', 'mahasiswa', NULL),
	(11, 'Testt', '123', '$2y$10$LQRizDqaJYl3ha0p9/UUFeGJ6beub.55EYvE7Eb1HBBFkF/kNUWd2', 'mahasiswa', NULL),
	(12, 'HMTI', 'hmti', '$2y$10$Qgmfd/yHFIcTy4E2zwuuJOQeFPEVDfEheNROfmoN3qZ2Q9ZQnoxfe', 'ormawa', NULL),
	(15, 'robotika', 'robotika', '$2y$10$3R0iP8NuHENY8iPa.iPwh.HNfdHSdgi5kIxLbXfu3E09A4a/VgB8y', 'ormawa', NULL);
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;

-- Dumping structure for table simkemawa.pengguna_old
CREATE TABLE IF NOT EXISTS `pengguna_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `hak_akses` varchar(20) DEFAULT '' COMMENT 'Admin, dll.',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Pengguna Aplikasi';

-- Dumping data for table simkemawa.pengguna_old: ~4 rows (approximately)
/*!40000 ALTER TABLE `pengguna_old` DISABLE KEYS */;
INSERT INTO `pengguna_old` (`id`, `nama_user`, `username`, `password`, `hak_akses`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(8, 'HMTI', 'hmti', 'pass', 'ormawa', '2020-09-17 22:26:51', NULL, NULL, NULL),
	(9, 'Olahraga', 'olahraga', 'uwu', 'ormawa', '2020-09-17 22:29:32', NULL, NULL, NULL),
	(10, 'Admin', 'admin', '$2y$10$RYt1rJ16oKK4M8OFJWiqa.OvDkAwzVuHG0gbFY8Xd/7srr8eWgLnm', 'admin', '2020-09-17 22:59:19', NULL, NULL, NULL),
	(11, 'mahasiswa', 'mahasiswa', '123', 'mahasiswa', '2019-06-18 03:02:25', 13434657, '2019-05-24 10:41:00', 435456);
/*!40000 ALTER TABLE `pengguna_old` ENABLE KEYS */;

-- Dumping structure for table simkemawa.prodi
CREATE TABLE IF NOT EXISTS `prodi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(244) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table simkemawa.prodi: ~4 rows (approximately)
/*!40000 ALTER TABLE `prodi` DISABLE KEYS */;
INSERT INTO `prodi` (`id`, `nama`) VALUES
	(1, 'Teknik Informatika'),
	(2, 'Teknik Sipi'),
	(3, 'Manajemen Bisnis Pariwisata'),
	(4, 'Agribisnis');
/*!40000 ALTER TABLE `prodi` ENABLE KEYS */;

-- Dumping structure for table simkemawa.proker
CREATE TABLE IF NOT EXISTS `proker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `pengguna_id` int(11) DEFAULT NULL,
  `ormawa_id` int(11) DEFAULT NULL,
  `ruangan_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1: Belum disetujui, 2: disetujui, 3: selesai',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.proker: ~7 rows (approximately)
/*!40000 ALTER TABLE `proker` DISABLE KEYS */;
INSERT INTO `proker` (`id`, `nama`, `pengguna_id`, `ormawa_id`, `ruangan_id`, `tanggal_mulai`, `tanggal_akhir`, `status`, `created_at`, `updated_at`) VALUES
	(2, 'Muswil Ismapeti', NULL, 4, 1, '2020-11-07', '2020-11-10', 1, NULL, NULL),
	(3, 'TM Peserta', NULL, 3, 1, '2020-11-01', '2020-11-02', 1, NULL, NULL),
	(4, 'Pemilihan Ketum', NULL, 5, 3, '2020-11-07', '2020-11-09', 1, NULL, NULL),
	(5, 'Poliwangi Bersholawat', NULL, 7, 5, '2020-09-07', '2020-09-07', 1, NULL, NULL),
	(6, 'Lomba PMR Wira', NULL, 11, 6, '2020-11-14', '2020-11-14', 1, NULL, NULL),
	(7, 'Doras', NULL, 11, 1, '2020-11-30', '2020-09-30', 1, NULL, NULL),
	(8, 'Test', NULL, 13, 1, '2020-10-11', '2020-10-22', NULL, NULL, NULL);
/*!40000 ALTER TABLE `proker` ENABLE KEYS */;

-- Dumping structure for table simkemawa.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.ruangan: ~5 rows (approximately)
/*!40000 ALTER TABLE `ruangan` DISABLE KEYS */;
INSERT INTO `ruangan` (`id`, `nama`) VALUES
	(1, 'Aula'),
	(3, 'Aula Robotika'),
	(5, 'Halaman dan Gedung 454'),
	(6, 'Gedung 454  Ruang B5'),
	(7, 'Zoom Meet');
/*!40000 ALTER TABLE `ruangan` ENABLE KEYS */;

-- Dumping structure for table simkemawa.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.status: ~0 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Dumping structure for table simkemawa.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `batas_transaksi` datetime DEFAULT NULL,
  `nama_bank` varchar(200) DEFAULT NULL,
  `nomor_rekening` varchar(200) DEFAULT NULL,
  `nama_rekening` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simkemawa.transaksi: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
