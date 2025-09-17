-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 12:15 PM
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
-- Database: `db_e-pendapatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_21_154414_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('i1VmvJYsGiHLfjG6DhvaxoqmcByJsApU8kO3Oos9', 1405001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia21DWHV0Tkg5SDNRQjQyMlVUaThCS3hGMU1FTDZsWDFLTVpiczBZZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vbWVudWFuZ2dhcmFuL21lbnVldmFsdWFzaS9leUpwZGlJNklrdzRSemcwVUZoQmFVSnlMMXBWYW05cGN5OW9VMUU5UFNJc0luWmhiSFZsSWpvaVJXWnVjRGwyVFUxRFVFUmlhalprTkZCSk9WcHlVVDA5SWl3aWJXRmpJam9pWmpabVpqZzRZVGMwWVRVeVlXUTJNekU1T0RWa1l6azJPVEJsTURCa01EUTROVEZqWVdFeU5tWmlOak00T1dGaE1EUXdZemt4WVRZMFpHVXlNbUZqTlNJc0luUmhaeUk2SWlKOSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQwNTAwMTt9', 1758035273),
('WPyE5uPQWF5og5lIZ7EoVqrgSCkizJ5y8aRQr7UX', 1405001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWXNJZEJxU0lHMXVsd0VkZGlsVEhncVd4MmdCTFprd0JFY0xibEp3eCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuL3NrcGR1cHRkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDA1MDAxO30=', 1757475387),
('ZBZP61PHZfpsGmJ0Bgrlks2QpkFdOa5DI6fpEzPU', 1405001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNEZVUzhBRkhNRDkxYnE3T1dDUDJrQ2RhVjBseW51bkZobnlsQkN3aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuL3JlYWxpc2FzaSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQwNTAwMTt9', 1756654562);

-- --------------------------------------------------------

--
-- Table structure for table `tb_agency`
--

CREATE TABLE `tb_agency` (
  `id_agency` varchar(15) NOT NULL,
  `nama_agency` varchar(150) NOT NULL,
  `kepala_agency` varchar(140) NOT NULL,
  `nip_agency` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_agency`
--

INSERT INTO `tb_agency` (`id_agency`, `nama_agency`, `kepala_agency`, `nip_agency`) VALUES
('AGN-0001', 'Balai Pelatihan Koperasi dan Usaha Kecil', 'LANANG BUDI WIBOWO, MP', '20000514 202421 1 001'),
('AGN-0002', 'Rumah Sakit Gigi dan Mulut Gusti Hasan Aman', '-', '-'),
('AGN-0003', 'Balai Latihan Kerja', '-', '-'),
('AGN-0004', 'Badan Pengembangan Sumber Daya Manusia', '-', '-'),
('AGN-0005', 'Biro Umum', '-', '-'),
('AGN-0006', 'Balai Pengelolaan Saran dan Prasarana Tanaman Pangan dan Hortikultura', '-', '-'),
('AGN-0007', 'Balai Teknologi Informasi dan Komunikasi Pendidikan', '-', '-'),
('AGN-0008', 'Taman Budaya', '-', '-'),
('AGN-0009', 'Dinas Sampel 1', '-', '-'),
('AGN-0010', 'Dinas Sampel 2', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bulan`
--

CREATE TABLE `tb_bulan` (
  `id_bulan` varchar(7) NOT NULL,
  `nama_bulan` varchar(20) NOT NULL,
  `nilaix_bulan` int(2) NOT NULL,
  `nilaiy_bulan` int(1) NOT NULL,
  `id_tahun` int(7) NOT NULL,
  `status_bulan` int(1) NOT NULL,
  `tipe_bulan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_bulan`
--

INSERT INTO `tb_bulan` (`id_bulan`, `nama_bulan`, `nilaix_bulan`, `nilaiy_bulan`, `id_tahun`, `status_bulan`, `tipe_bulan`) VALUES
('202501', 'Januari', 1, 1, 2025, 1, 1),
('202502', 'Februari', 2, 1, 2025, 1, 1),
('202503', 'Maret', 3, 1, 2025, 0, 1),
('202504', 'April', 4, 2, 2025, 0, 1),
('202505', 'Mei', 5, 2, 2025, 0, 1),
('202506', 'Juni', 6, 2, 2025, 0, 1),
('202507', 'Juli', 7, 3, 2025, 0, 1),
('202508', 'Agustus', 8, 3, 2025, 0, 1),
('202509', 'September', 9, 3, 2025, 0, 1),
('202510', 'Oktober', 10, 4, 2025, 1, 2),
('202511', 'November', 11, 4, 2025, 0, 2),
('202512', 'Desember', 12, 4, 2025, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_evaluasi`
--

CREATE TABLE `tb_evaluasi` (
  `id_evaluasi` varchar(13) NOT NULL,
  `fpendukung` text NOT NULL,
  `fpenghambat` text NOT NULL,
  `tindaklanjut` text NOT NULL,
  `status_evaluasi` int(1) NOT NULL,
  `id_triwulan` varchar(5) NOT NULL,
  `id_agency` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_evaluasi`
--

INSERT INTO `tb_evaluasi` (`id_evaluasi`, `fpendukung`, `fpenghambat`, `tindaklanjut`, `status_evaluasi`, `id_triwulan`, `id_agency`) VALUES
('20251-EV-0001', 'Dengan memanfaatkan media cetak dalam melakukan promosi sehingga dapat memberikan informasi kepada masyarakat terkait adanya sewa gedung pada Kantor Balatkop', 'Kurang estetikanya bangunan gedung seperti pada gedung Aula yang sudah berusia 20 tahun', 'Berupaya untuk melakukan perencanaan dan merealisasikan pembaruan gedung', 1, '20251', 'AGN-0001'),
('20251-EV-0002', '1', '2', '3', 1, '20251', 'AGN-0002');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenretribusi`
--

CREATE TABLE `tb_jenretribusi` (
  `id_jr` varchar(15) NOT NULL,
  `kode_jr` varchar(9) NOT NULL,
  `nama_jr` varchar(140) DEFAULT NULL,
  `status_jr` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_jenretribusi`
--

INSERT INTO `tb_jenretribusi` (`id_jr`, `kode_jr`, `nama_jr`, `status_jr`) VALUES
('JR-0001', '4.1.02.01', 'Retribusi jasa Umum', 1),
('JR-0002', '4.1.02.02', 'Retribusi Jasa Usaha', 1),
('JR-0003', '4.1.02.03', 'Retribusi Perizinan Tertentu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id_menu` varchar(7) NOT NULL,
  `tipe_menu` int(1) NOT NULL,
  `uraian_menu` varchar(80) NOT NULL,
  `keterangan_menu` int(4) NOT NULL,
  `status_menu` int(1) NOT NULL,
  `nilai_menu` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`id_menu`, `tipe_menu`, `uraian_menu`, `keterangan_menu`, `status_menu`, `nilai_menu`) VALUES
('b011111', 2, 'Januari', 2147483647, 0, 1),
('b012025', 2, 'Januari', 2025, 0, 1),
('b021111', 2, 'Februari', 2147483647, 0, 1),
('b022025', 2, 'Februari', 2025, 0, 1),
('b031111', 2, 'Maret', 2147483647, 0, 1),
('b032025', 2, 'Maret', 2025, 0, 1),
('b041111', 2, 'April', 2147483647, 0, 2),
('b042025', 2, 'April', 2025, 0, 2),
('b051111', 2, 'Mei', 2147483647, 0, 2),
('b052025', 2, 'Mei', 2025, 0, 2),
('b061111', 2, 'Juni', 2147483647, 0, 2),
('b062025', 2, 'Juni', 2025, 0, 2),
('b071111', 2, 'Juli', 2147483647, 0, 3),
('b072025', 2, 'Juli', 2025, 0, 3),
('b081111', 2, 'Agustus', 2147483647, 0, 3),
('b082025', 2, 'Agustus', 2025, 0, 3),
('b091111', 2, 'September', 2147483647, 0, 3),
('b092025', 2, 'September', 2025, 0, 3),
('b101111', 3, 'Oktober', 2147483647, 0, 4),
('b102025', 3, 'Oktober', 2025, 0, 4),
('b111111', 3, 'November', 2147483647, 0, 4),
('b112025', 3, 'November', 2025, 0, 4),
('b121111', 3, 'Desember', 2147483647, 0, 4),
('b122025', 3, 'Desember', 2025, 0, 4),
('tm11111', 1, '1111111111111111111', 1, 1, 0),
('tm2025', 1, '2025', 1, 1, 5),
('tp11111', 1, '1111111111111111111', 2, 0, 0),
('tp2025', 1, '2025', 2, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ojkretribusi`
--

CREATE TABLE `tb_ojkretribusi` (
  `id_ojk` varchar(15) NOT NULL,
  `kode_ojk` varchar(17) NOT NULL,
  `nama_ojk` varchar(150) NOT NULL,
  `status_ojk` int(1) NOT NULL,
  `id_sr` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_ojkretribusi`
--

INSERT INTO `tb_ojkretribusi` (`id_ojk`, `kode_ojk`, `nama_ojk`, `status_ojk`, `id_sr`) VALUES
('oj-000001', '4.1.02.01.01.0001', 'Retribusi Pelayanan Kesehatan di Puskesmas', 1, 'SR-00001'),
('oj-000002', '4.1.02.01.01.0002', 'Retribusi Pelayanan Kesehatan di Puskesmas Keliling', 1, 'SR-00001'),
('oj-000003', '4.1.02.01.01.0003', 'Retribusi Pelayanan Kesehatan di Puskesmas Pembantu', 1, 'SR-00001'),
('oj-000004', '4.1.02.01.01.0004', 'Retribusi Pelayanan Kesehatan di Balai Pengobatan', 1, 'SR-00001'),
('oj-000005', '4.1.02.01.01.0005', 'Retribusi Pelayanan Kesehatan di Rumah Sakit Umum Daerah', 1, 'SR-00001'),
('oj-000006', '4.1.02.01.01.0006', 'Retribusi Pelayanan Kesehatan di Tempat Pelayanan Kesehatan Lainnya yang Sejenis', 1, 'SR-00001'),
('oj-000007', '4.1.02.01.02.0001', 'Retribusi Pelayanan Persampahan/ Kebersihan', 1, 'SR-00002'),
('oj-000008', '4.1.02.01.03.0001', 'Retribusi Pelayanan Penguburan/Pemakaman termasuk Penggalian dan Pengurukan serta Pembakaran/Pengabuan Mayat', 1, 'SR-00003'),
('oj-000009', '4.1.02.01.03.0002', 'Retribusi Sewa Tempat Pemakaman atau Pembakaran/Pengabuan Mayat', 1, 'SR-00003'),
('oj-000010', '4.1.02.01.03.00xx', 'Bebarang', 1, 'SR-00016');

-- --------------------------------------------------------

--
-- Table structure for table `tb_operator`
--

CREATE TABLE `tb_operator` (
  `id_operator` varchar(15) NOT NULL,
  `nama_opt` varchar(150) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `id_agency` varchar(15) NOT NULL,
  `id_tahun` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_operator`
--

INSERT INTO `tb_operator` (`id_operator`, `nama_opt`, `username`, `password`, `id_agency`, `id_tahun`) VALUES
('OP-0001', 'Bakatkop', 'balaikoperasi', '$2y$12$0zsYxn38UWnHTJ5oCB7aMOoM1byblJFUzAEigJjeh8pkEjmzvEZHC', 'AGN-0001', '2025'),
('OP-0002', 'RS Gusti Hasan Aman', 'rsgustihasanaman', '$2y$12$RZJIjRFwoX2O2ZHnhnbHQ.JYi1iqTjGCzX2jNbsKETIhFHwJt/v0O', 'AGN-0002', '2025'),
('OP-0003', 'Dinas Sampel 1', 'dinassampel1', '$2y$12$SdvB/eZdIfDewMeWcOvO..QLfRaypTNQ7Cxy5ISiKGeSzqRz77eXa', 'AGN-0009', '2025'),
('OP-0004', NULL, 'dinassampel2', '$2y$12$l6WJI3Et07kg/X82VUojD.nuZ/sBSleA1ltVcAQz.gl/6GMgbWTAu', 'AGN-0010', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `tb_realisasi`
--

CREATE TABLE `tb_realisasi` (
  `id_realisasi` varchar(21) NOT NULL,
  `pagu_realisasi` decimal(20,0) NOT NULL,
  `status_realisasi` int(1) NOT NULL,
  `id_rtarget` varchar(17) NOT NULL,
  `id_bulan` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_realisasi`
--

INSERT INTO `tb_realisasi` (`id_realisasi`, `pagu_realisasi`, `status_realisasi`, `id_rtarget`, `id_bulan`) VALUES
('202501.R-00001', 1000000, 1, 'RT2025-0001-0001', '202501'),
('202501.R-00002', 5000000, 1, 'RT2025-0001-0002', '202501'),
('202501.R-00003', 2300000, 1, 'RT2025-0001-0003', '202501'),
('202501.R-00004', 3000000, 1, 'RT2025-0003-0001', '202501'),
('202501.R-00005', 2000000, 1, 'RT2025-0003-0002', '202501'),
('202501.R-00006', 1000000, 1, 'RT2025-0003-0005', '202501'),
('202501.R-00007', 6000000, 1, 'RT2025-0003-0004', '202501'),
('202501.R-00008', 7000000, 1, 'RT2025-0003-0003', '202501'),
('202502.R-00001', 1400000, 1, 'RT2025-0001-0001', '202502'),
('202502.R-00002', 3200000, 1, 'RT2025-0001-0002', '202502'),
('202502.R-00003', 1200000, 1, 'RT2025-0001-0003', '202502'),
('202510.R-00001', 2000000, 1, 'RT2025-0001-0001', '202503'),
('202510.R-00002', 1000000, 1, 'RT2025-0001-0002', '202503'),
('202510.R-00003', 5000000, 1, 'RT2025-0001-0003', '202503'),
('202510.R-00004', 10000000, 1, 'RT2025-0001-0004', '202504');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rtarget`
--

CREATE TABLE `tb_rtarget` (
  `id_rtarget` varchar(17) NOT NULL,
  `uraian_rtarget` varchar(150) NOT NULL,
  `pagu_rtarget` double NOT NULL,
  `status_rtarget` int(1) NOT NULL,
  `pagu_prtarget` double NOT NULL,
  `id_ojk` varchar(15) NOT NULL,
  `id_target` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rtarget`
--

INSERT INTO `tb_rtarget` (`id_rtarget`, `uraian_rtarget`, `pagu_rtarget`, `status_rtarget`, `pagu_prtarget`, `id_ojk`, `id_target`) VALUES
('RT2025-0001-0001', 'Ayam', 8000000, 0, 5100000, 'oj-000001', 'T2025-0001'),
('RT2025-0001-0002', 'Makanan Makanan Penambah Nafsu Makan', 1000000, 0, 900000, 'oj-000007', 'T2025-0001'),
('RT2025-0001-0003', 'Retribusi Penjualan Obat-Obatan untuk Penambah Stamina Atlet', 1000000, 0, 500000, 'oj-000010', 'T2025-0001'),
('RT2025-0001-0004', 'Contoh Anggaran Perubahan', 0, 1, 1500000, 'oj-000007', 'T2025-0001'),
('RT2025-0002-0001', 'Penjualan Obat Lari', 1000000, 0, 1000000, 'oj-000004', 'T2025-0002'),
('RT2025-0002-0002', 'Baju Sarana Prasarana Perawat', 9000000, 0, 9000000, 'oj-000007', 'T2025-0002'),
('RT2025-0003-0001', 'Sampel 1', 20000000, 0, 20000000, 'oj-000001', 'T2025-0003'),
('RT2025-0003-0002', 'Sampel 2', 30000000, 0, 30000000, 'oj-000007', 'T2025-0003'),
('RT2025-0003-0003', 'Sampel 3', 15000000, 0, 15000000, 'oj-000010', 'T2025-0003'),
('RT2025-0003-0004', 'Sampel 4', 25000000, 0, 25000000, 'oj-000009', 'T2025-0003'),
('RT2025-0003-0005', 'Sampel 5', 10000000, 0, 10000000, 'oj-000009', 'T2025-0003');

-- --------------------------------------------------------

--
-- Table structure for table `tb_subretribusi`
--

CREATE TABLE `tb_subretribusi` (
  `id_sr` varchar(15) NOT NULL,
  `kode_sr` varchar(12) NOT NULL,
  `nama_sr` varchar(150) NOT NULL,
  `status_sr` int(1) NOT NULL,
  `id_jr` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_subretribusi`
--

INSERT INTO `tb_subretribusi` (`id_sr`, `kode_sr`, `nama_sr`, `status_sr`, `id_jr`) VALUES
('SR-00001', '4.1.02.01.01', 'Retribusi Pelayanan Kesehatan', 1, 'JR-0001'),
('SR-00002', '4.1.02.01.02', 'Retribusi Pelayanan Persampahan/ Kebersihan', 1, 'JR-0001'),
('SR-00003', '4.1.02.01.03', 'Retribusi Pelayanan Pemakaman dan Pengabuan Mayat', 1, 'JR-0001'),
('SR-00004', '4.1.02.01.04', 'Retribusi Pelayanan Parkir di Tepi Jalan Umum', 1, 'JR-0001'),
('SR-00005', '4.1.02.01.05', 'Retribusi Pelayanan Pasar', 1, 'JR-0001'),
('SR-00006', '4.1.02.01.06', 'Retribusi Pengujian Kendaraan Bermotor', 1, 'JR-0001'),
('SR-00007', '4.1.02.01.07', 'Retribusi Pemeriksaan Alat Pemadam Kebakaran', 1, 'JR-0001'),
('SR-00008', '4.1.02.01.08', 'Retribusi Penggantian Biaya Cetak Peta', 1, 'JR-0001'),
('SR-00009', '4.1.02.01.09', 'Retribusi Penyediaan dan/atau Penyedotan Kakus', 1, 'JR-0001'),
('SR-00010', '4.1.02.01.10', 'Retribusi Pengolahan Limbah Cair', 1, 'JR-0001'),
('SR-00011', '4.1.02.01.11', 'Retribusi Pelayanan Tera/Tera Ulang', 1, 'JR-0001'),
('SR-00012', '4.1.02.01.12', 'Retribusi Pelayanan Pendidikan', 1, 'JR-0001'),
('SR-00013', '4.1.02.01.13', 'Retribusi Pengawasan dan Pengendalian Menara Telekomunikasi', 1, 'JR-0001'),
('SR-00014', '4.1.02.01.14', 'Retribusi Pelayanan Kebersihan', 1, 'JR-0001'),
('SR-00015', '4.1.02.01.15', 'Retribusi Pengendalian Lalu Lintas', 1, 'JR-0001'),
('SR-00016', '4.1.02.01.16', 'Retribusi Pengendalian Kebakaran', 1, 'JR-0003');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tahun`
--

CREATE TABLE `tb_tahun` (
  `id_tahun` int(7) NOT NULL,
  `apbd_tahun` int(1) NOT NULL,
  `apbdp_tahun` int(1) NOT NULL,
  `status_tahun` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tahun`
--

INSERT INTO `tb_tahun` (`id_tahun`, `apbd_tahun`, `apbdp_tahun`, `status_tahun`) VALUES
(2025, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_target`
--

CREATE TABLE `tb_target` (
  `id_target` varchar(15) NOT NULL,
  `jen_target` varchar(10) NOT NULL,
  `pagu_target` double NOT NULL,
  `pagu_ptarget` double DEFAULT NULL,
  `surat_apbd` text DEFAULT NULL,
  `surat_apbdp` text DEFAULT NULL,
  `status_target` int(1) NOT NULL,
  `id_tahun` int(4) NOT NULL,
  `id_agency` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_target`
--

INSERT INTO `tb_target` (`id_target`, `jen_target`, `pagu_target`, `pagu_ptarget`, `surat_apbd`, `surat_apbdp`, `status_target`, `id_tahun`, `id_agency`) VALUES
('T2025-0001', '1', 10000000, 8000000, 'Surat Usulan Target Retribusi APBD 2025 Balai Pelatihan Koperasi dan Usaha Kecil.pdf', 'Surat Usulan Target Retribusi APBD Perubahan 2025 Balai Pelatihan Koperasi dan Usaha Kecil.pdf', 3, 2025, 'AGN-0001'),
('T2025-0002', '1', 10000000, 10000000, 'Surat Usulan Target Retribusi APBD 2025 Rumah Sakit Gigi dan Mulut Gusti Hasan Aman.pdf', NULL, 1, 2025, 'AGN-0002'),
('T2025-0003', '1', 100000000, 100000000, 'Surat Usulan Target Retribusi APBD 2025 Dinas Sampel 2.pdf', NULL, 1, 2025, 'AGN-0010');

-- --------------------------------------------------------

--
-- Table structure for table `tb_triwulan`
--

CREATE TABLE `tb_triwulan` (
  `id_triwulan` varchar(5) NOT NULL,
  `nama_triwulan` varchar(12) NOT NULL,
  `nilai_triwulan` int(1) NOT NULL,
  `status_triwulan` int(1) NOT NULL,
  `id_tahun` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_triwulan`
--

INSERT INTO `tb_triwulan` (`id_triwulan`, `nama_triwulan`, `nilai_triwulan`, `status_triwulan`, `id_tahun`) VALUES
('20251', 'Triwulan I', 1, 1, '2025'),
('20252', 'Triwulan II', 2, 1, '2025'),
('20253', 'Triwulan III', 3, 0, '2025'),
('20254', 'Triwulan IV', 4, 0, '2025');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_tahun` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `id_tahun`) VALUES
(1405001, 'Asfar', 'admin@asfar.rn', NULL, '$2y$12$HCenGFMWvfdJ74Y78sKVbeXgiZrdLg2ANWj1KIcVM3AUbqRmsConq', NULL, NULL, NULL, 2025);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tb_agency`
--
ALTER TABLE `tb_agency`
  ADD PRIMARY KEY (`id_agency`);

--
-- Indexes for table `tb_bulan`
--
ALTER TABLE `tb_bulan`
  ADD PRIMARY KEY (`id_bulan`);

--
-- Indexes for table `tb_evaluasi`
--
ALTER TABLE `tb_evaluasi`
  ADD PRIMARY KEY (`id_evaluasi`);

--
-- Indexes for table `tb_jenretribusi`
--
ALTER TABLE `tb_jenretribusi`
  ADD PRIMARY KEY (`id_jr`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tb_ojkretribusi`
--
ALTER TABLE `tb_ojkretribusi`
  ADD PRIMARY KEY (`id_ojk`);

--
-- Indexes for table `tb_operator`
--
ALTER TABLE `tb_operator`
  ADD PRIMARY KEY (`id_operator`);

--
-- Indexes for table `tb_realisasi`
--
ALTER TABLE `tb_realisasi`
  ADD PRIMARY KEY (`id_realisasi`);

--
-- Indexes for table `tb_rtarget`
--
ALTER TABLE `tb_rtarget`
  ADD PRIMARY KEY (`id_rtarget`);

--
-- Indexes for table `tb_subretribusi`
--
ALTER TABLE `tb_subretribusi`
  ADD PRIMARY KEY (`id_sr`);

--
-- Indexes for table `tb_tahun`
--
ALTER TABLE `tb_tahun`
  ADD PRIMARY KEY (`id_tahun`);

--
-- Indexes for table `tb_target`
--
ALTER TABLE `tb_target`
  ADD PRIMARY KEY (`id_target`);

--
-- Indexes for table `tb_triwulan`
--
ALTER TABLE `tb_triwulan`
  ADD PRIMARY KEY (`id_triwulan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1405002;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
