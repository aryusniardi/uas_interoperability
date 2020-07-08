-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 12:44 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_interoperability`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE `keluhan` (
  `keluhan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `jenis_keluhan` enum('pelayanan','infrastruktur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_keluhan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_keluhan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggapan` enum('ditanggapi','belum ditanggapi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum ditanggapi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`keluhan_id`, `user_id`, `jenis_keluhan`, `lokasi_keluhan`, `foto_keluhan`, `isi_keluhan`, `tanggapan`, `created_at`, `updated_at`) VALUES
(4, 2, 'pelayanan', 'Cimahi', 'foto_keluhan2', 'ini isi keluhan harus gatau berapa', 'belum ditanggapi', '2020-01-16 02:08:02', '2020-01-16 02:08:02'),
(5, 4, 'infrastruktur', 'dimana', NULL, 'ini isi keluhan', 'belum ditanggapi', NULL, NULL),
(6, 5, 'pelayanan', 'gatau dimana', NULL, 'ini isi keluhan', 'ditanggapi', NULL, '2020-01-23 03:17:58'),
(7, 4, 'infrastruktur', 'dimana', NULL, 'ini isi keluhan', 'ditanggapi', NULL, '2020-01-17 18:04:04'),
(8, 5, 'pelayanan', 'gatau dimana', NULL, 'ini isi keluhan', 'ditanggapi', NULL, '2020-01-23 03:20:50'),
(10, 4, 'infrastruktur', 'cimahi barat', 'foto_keluhan25', 'ini isi keluhan dari user sekian', 'belum ditanggapi', '2020-01-18 11:09:39', '2020-01-18 11:09:39'),
(11, 4, 'infrastruktur', 'cimahi barat', 'foto_keluhan89', 'ini isi keluhan dari user sekian', 'belum ditanggapi', '2020-01-18 11:38:40', '2020-01-18 11:38:40'),
(12, 6, 'infrastruktur', 'cimahi barat', 'foto_keluhan8', 'ini isi keluhan dari user sekian', 'belum ditanggapi', '2020-01-23 13:51:27', '2020-01-23 13:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_01_07_134827_create_user_table', 1),
(2, '2020_01_09_174844_petugas', 1),
(3, '2020_01_10_114929_keluhan', 1),
(4, '2020_01_10_114942_saran', 1),
(5, '2020_01_10_114952_tanggapan', 1),
(6, '2020_01_14_120020_tambah_isi_keluhan_saran', 2),
(7, '2020_01_14_121217_tambah_tanggapan_keluhan', 3);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `petugas_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','super admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`petugas_id`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(4, 'adminadmin@admin.com', 'adminsatu', 'admin', '2020-01-11 06:55:23', '2020-01-17 16:58:07'),
(5, 'admins@admin.coq', '$2y$10$fZyR1qKDMOeynGsnfP4iueZR502xUIqYwZ7xiUrEucZbsYwBkbB/K', 'admin', '2020-01-11 06:55:29', '2020-01-11 06:55:29'),
(7, 'admins@admin.cs', '$2y$10$VqYmQdFc91iB/Glm4w2Dh.TE4Ymc1trYnyUDZ8Lkk7qNTpWPu792q', 'admin', '2020-01-11 06:55:45', '2020-01-11 06:55:45'),
(8, 'admins@admin.ca', '$2y$10$Edd5mmjg7pNf0lo3Pq4n8elz/ha40seYk64bvFtzRMqX83K96.nRi', 'admin', '2020-01-11 06:55:48', '2020-01-11 06:55:48'),
(9, 'admins@admin.cw', '$2y$10$nLWz4reakTcb2.4fp5dWyuUfkTI6ulyYuoBx7v5bdGRGPLAuaJwtu', 'admin', '2020-01-11 06:55:52', '2020-01-11 06:55:52'),
(10, 'admins@admin.ce', '$2y$10$Wwac/Kj./Wh/G1cj3QUHJ.FL2VATCSg3G6GSvTb0WXAIU3Aqf2iUm', 'admin', '2020-01-11 06:55:55', '2020-01-11 06:55:55'),
(11, 'admins@admin.ceq', '$2y$10$j/y.xT/Ilxmyqua5huja1.CYKGQu3Z95V9y.7T.Bmu3yfRCAV3hyi', 'admin', '2020-01-11 06:56:02', '2020-01-11 06:56:02'),
(12, 'adminsatu@admin.com', '$2y$10$P/Cqf/QNj4ym9UYmixrX0OXRwh61JwKswZC8lW08ExRFesPxIeZgG', 'super admin', '2020-01-11 10:33:23', '2020-01-11 10:33:23'),
(13, 'arief@arief.com', '$2y$10$K1LlEFGtXqDGvLderaa3kekr1MzYSrgU49AdS.gIVGWhfdVJ7r8QK', 'admin', '2020-01-12 07:14:02', '2020-01-12 07:14:02'),
(14, 'ariefrahmany@arief.com', 'password', 'super admin', '2020-01-13 14:42:27', '2020-01-23 03:09:22'),
(15, 'ariefrahmany@admin.com', '$2y$10$Sn6tpV61vOC1VEXl7mFF1eQyijvzWx6EsOdPYmNXWTByyHKC.PISO', 'super admin', '2020-01-23 03:02:55', '2020-01-23 03:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `saran_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `jenis_saran` enum('pelayanan','infrastruktur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_saran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_saran` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`saran_id`, `user_id`, `jenis_saran`, `lokasi_saran`, `isi_saran`, `created_at`, `updated_at`) VALUES
(1, 1, 'pelayanan', 'CImahi', 'askdlaknsdlkansldnalsndlasd', NULL, NULL),
(3, 4, 'pelayanan', 'cimahi', 'ini isi saran', '2020-01-17 23:45:04', '2020-01-17 23:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `tanggapan_id` bigint(20) UNSIGNED NOT NULL,
  `keluhan_id` bigint(20) NOT NULL,
  `petugas_id` bigint(20) NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggapan` enum('Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`tanggapan_id`, `keluhan_id`, `petugas_id`, `isi`, `tanggapan`, `alasan`, `created_at`, `updated_at`) VALUES
(1, 2, 12, '', 'Diterima', 'mau duapulun empat character', '2020-01-13 14:30:43', '2020-01-13 14:30:43'),
(3, 2, 12, '', 'Diterima', 'mau duapulun empat character', '2020-01-13 14:43:59', '2020-01-13 14:43:59'),
(7, 1, 12, 'ini isi keluhan', 'Diterima', 'ini alasan nya kenapa ditolak', '2020-01-13 14:53:37', '2020-01-23 03:23:58'),
(8, 1, 12, '', 'Ditolak', 'harus ada duapuluh empat character', '2020-01-13 14:53:59', '2020-01-13 14:53:59'),
(9, 2, 12, '', 'Diterima', 'harus ada duapuluh empat character', '2020-01-13 16:25:03', '2020-01-13 16:25:03'),
(10, 7, 12, 'ini isi keluhan', 'Diterima', 'ini alasan nya kenapa ditolak', '2020-01-17 18:04:04', '2020-01-17 18:04:04'),
(11, 6, 15, 'ini isi keluhan', 'Diterima', 'ini alasan nya kenapa ditolak', '2020-01-23 03:17:58', '2020-01-23 03:17:58'),
(12, 8, 15, 'ini isi keluhan', 'Diterima', 'ini alasan nya kenapa ditolak', '2020-01-23 03:20:50', '2020-01-23 03:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `nama`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Arief Rahman Y', 'arief@arief.com', '$2y$10$GsOXrkYe9hOXTuYfdv1iOOgiYHDeWzPWJja9qgsWa./eg/tDQc7XS', '2020-01-11 10:34:48', '2020-01-11 10:34:48'),
(2, 'Arief Rahman Y', 'user@gmail.com', '$2y$10$KOG1g5kJSlO1o3i8IipsMeeXA.qzSvIGZQW.cW/3JcN0g7J7gOSkS', '2020-01-13 07:15:05', '2020-01-13 07:15:05'),
(5, 'arief rahman y', 'ariefrahmany@admin.com', 'passwordsatu', '2020-01-23 02:14:14', '2020-01-23 02:14:44'),
(6, 'arief rahman y', 'useremail@user.com', '$2y$10$.ya8bU0ngPAfPNPoalwHauKjtIFOwcN4EulnWZ9B2JolQTSsOvuXq', '2020-01-23 03:29:55', '2020-01-23 03:29:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`keluhan_id`),
  ADD KEY `user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`petugas_id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`saran_id`),
  ADD KEY `user_id_foreign` (`user_id`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`tanggapan_id`),
  ADD KEY `keluhan_id_foreign` (`keluhan_id`),
  ADD KEY `petugas_id_foreign` (`petugas_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `keluhan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `petugas_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `saran_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `tanggapan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
