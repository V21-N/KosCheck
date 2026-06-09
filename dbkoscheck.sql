-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260526.9a43c2e222
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2026 at 06:37 PM
-- Server version: 8.4.3
-- PHP Version: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbkoscheck`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` enum('homepage','search_result','kos_detail','sidebar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `max_clicks` int DEFAULT NULL,
  `click_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `user_id`, `name`, `image_url`, `target_url`, `position`, `area`, `start_date`, `end_date`, `is_active`, `max_clicks`, `click_count`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laundry Kiloan Medan', 'https://picsum.photos/seed/laundry1/400/200', 'https://wa.me/6281234567001', 'homepage', 'medan', '2026-05-01', '2026-08-31', 1, NULL, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(2, NULL, 'Catering Masakan Rumahan', 'https://picsum.photos/seed/catering1/400/200', 'https://wa.me/6281234567002', 'homepage', 'medan', '2026-05-01', '2026-07-31', 1, NULL, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(3, NULL, 'Internet WiFi Unlimited', 'https://picsum.photos/seed/wifi1/400/200', 'https://wa.me/6281234567003', 'search_result', 'medan', '2026-05-01', '2026-07-01', 1, NULL, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, NULL, 'Jasa Pindahan Kos', 'https://picsum.photos/seed/pindahan1/400/200', 'https://wa.me/6281234567004', 'kos_detail', 'medan', '2026-05-01', '2026-07-31', 1, NULL, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(5, NULL, 'Minimarket Dekat Kos', 'https://picsum.photos/seed/minimart1/400/200', 'https://wa.me/6281234567005', 'search_result', 'medan', '2026-05-01', '2026-08-31', 1, NULL, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kos_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `move_in_date` date DEFAULT NULL,
  `duration_months` tinyint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `kos_id`, `status`, `rejection_reason`, `phone`, `university`, `gender`, `move_in_date`, `duration_months`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(2, 8, 1, 'rejected', 'Maaf, kamar sudah terisi. Silakan pilih kos lain.', NULL, NULL, NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 10, 11, 'pending', NULL, '081376448988', 'Universitas Islam Negeri Sumatera Utara', 'L', '2026-06-09', 6, '2026-06-09 06:26:05', '2026-06-09 06:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `icon`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'WiFi', 'wifi', 'wifi', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(2, 'AC', 'ac', 'ac', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(3, 'Kamar Mandi Dalam', 'bathroom', 'bathroom_in', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(4, 'Kamar Mandi Luar', 'bathroom', 'bathroom_out', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(5, 'Akses 24 Jam', 'clock', '24_hour', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(6, 'Parkir Motor', 'parking', 'parking_motor', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(7, 'Parkir Mobil', 'parking', 'parking_car', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(8, 'Dapur', 'kitchen', 'kitchen', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(9, 'Laundry', 'laundry', 'laundry', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(10, 'CCTV', 'cctv', 'cctv', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(11, 'Keamanan 24 Jam', 'security', 'security', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(12, 'TV', 'tv', 'tv', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(13, 'Kipas Angin', 'fan', 'fan', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(14, 'Spring Bed', 'bed', 'bed', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(15, 'Lemari Pakaian', 'wardrobe', 'wardrobe', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(16, 'Meja Belajar', 'desk', 'desk', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(17, 'Air PAM', 'water', 'water', '2026-05-29 20:50:49', '2026-05-29 20:50:49'),
(18, 'Air Galon', 'water', 'water_gallon', '2026-05-29 20:50:49', '2026-05-29 20:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_kos`
--

CREATE TABLE `favorite_kos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kos_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorite_kos`
--

INSERT INTO `favorite_kos` (`id`, `user_id`, `kos_id`, `created_at`, `updated_at`) VALUES
(2, 10, 2, '2026-06-09 07:02:44', '2026-06-09 07:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kos`
--

CREATE TABLE `kos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `price` int NOT NULL,
  `gender` enum('putra','putri','campur') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'campur',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whatsapp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','active','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `premium_expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kos`
--

INSERT INTO `kos` (`id`, `user_id`, `name`, `slug`, `address`, `latitude`, `longitude`, `price`, `gender`, `description`, `whatsapp`, `phone`, `status`, `is_premium`, `premium_expires_at`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Kos Melati Indah', 'kos-melati-indah', 'Jl. Merdeka No. 15, Medan', 3.59520000, 98.67220000, 800000, 'campur', 'Kos nyaman dengan suasana tenang, cocok untuk mahasiswa. Lokasi strategis dekat kampus USU dan UNIMED. Akses jalan mudah, lingkungan aman dengan keamanan 24 jam.', '081234567890', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:49', '2026-06-09 11:28:53'),
(2, 3, 'Kos Anggrek Residence', 'kos-anggrek-residence', 'Jl. Sudirman No. 42, Medan', 3.58940000, 98.67310000, 650000, 'putra', 'Kos putra minimalis dengan fasilitas lengkap. Dilengkapi AC, WiFi, dan kamar mandi dalam. Lokasi strategis di pusat kota Medan.', '6281234567891', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-06-09 11:28:44'),
(3, 4, 'Kos Cemara Asri', 'kos-cemara-asri', 'Jl. Pancing No. 8, Medan', 3.59850000, 98.68120000, 550000, 'campur', 'Kos campur dengan harga terjangkau. Fasilitas dasar tersedia: WiFi, parkir, dan dapur bersama. Lingkungan asri dan nyaman.', '6281234567892', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 5, 'Kos Kenanga Family', 'kos-kenanga-family', 'Jl. Ahmad Yani No. 25, Medan', 3.58760000, 98.66980000, 1200000, 'putri', 'Kos premium untuk mahasiswa dengan standar hotel. Fasilitas lengkap termasuk AC, WiFi, TV, dan laundry. Keamanan terjamin dengan CCTV.', '6281234567893', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-06-09 11:28:47'),
(5, 6, 'Kos Mawar Bersinar', 'kos-mawar-bersinar', 'Jl. Sisingamangaraja No. 11, Medan', 3.59120000, 98.67560000, 450000, 'putra', 'Kos putra ekonomis dekat kampus. Fasilitas: WiFi, akses 24 jam, parkir luas. Lingkungan aman dan bersih.', '6281234567894', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(6, 2, 'Kos Flamboyan Premium', 'kos-flamboyan-premium', 'Jl. HM Jhoni No. 33, Medan', 3.59410000, 98.67120000, 950000, 'campur', 'Kos premium campur dengan lokasi strategis. Dekat dengan pusat perbelanjaan dan akses transportasi umum. Fasilitas lengkap.', '6281234567895', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-06-09 11:28:50'),
(7, 3, 'Kos Teratai Hijau', 'kos-teratai-hijau', 'Jl. Imam Bonjol No. 7, Medan', 3.59680000, 98.66890000, 700000, 'putri', 'Kos putri dengan nuansa asri dan tenang. Dilengkapi WiFi, AC, dan kamar mandi dalam. Keamanan 24 jam dengan akses kartu.', '6281234567896', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-06-09 11:29:02'),
(8, 4, 'Kos Dahlia Residence', 'kos-dahlia-residence', 'Jl. S. Parman No. 56, Medan', 3.59230000, 98.67780000, 580000, 'putra', 'Kos putra nyaman dengan fasilitas lengkap. Lokasi sangat strategis dekat dengan rumah sakit dan universitas.', '6281234567897', NULL, 'active', 0, NULL, 1, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(9, 2, 'Kos Aselole', 'kos-aselole', 'Jl. Lapangan Golf, No.49', NULL, NULL, 1200000, 'putra', 'Kos premium khusus putra dengan suasana tenang, WiFi kencang, dan dekat kampus USU serta banyak warung makan 24 jam.', '081234567890', NULL, 'active', 0, NULL, 1, NULL, '2026-05-31 18:51:48', '2026-06-01 12:14:36'),
(10, 2, 'Kos Icikiwir', 'kos-icikiwir', 'Jl. Lapangan Golf, No.50', NULL, NULL, 1200000, 'putra', 'Kos premium khusus putra dengan suasana tenang, WiFi kencang, dan dekat kampus USU serta banyak warung makan 24 jam.', '081234567890', NULL, 'active', 0, NULL, 1, NULL, '2026-05-31 20:25:42', '2026-06-01 12:14:58'),
(11, 2, 'Kos Jomok(erto)', 'kos-jomokerto', 'Jl. Jamin Ginting No. 1123', NULL, NULL, 1500000, 'putra', 'Kos premium khusus putra dengan suasana tenang, WiFi kencang, dan dekat kampus USU serta banyak warung makan 24 jam.', '081234567890', NULL, 'active', 0, NULL, 1, NULL, '2026-06-01 09:42:56', '2026-06-01 12:14:49'),
(12, 2, 'Kos Digidaw', 'kos-digidaw', 'Jl. Jamin Ginting, No.112', NULL, NULL, 800000, 'putra', 'Kos premium khusus putra dengan suasana tenang, WiFi kencang, dan dekat kampus USU serta banyak warung makan 24 jam.', '081234567890', NULL, 'active', 1, '2026-07-09 11:29:34', 1, NULL, '2026-06-02 01:29:05', '2026-06-09 11:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `kos_facilities`
--

CREATE TABLE `kos_facilities` (
  `kos_id` bigint UNSIGNED NOT NULL,
  `facility_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kos_facilities`
--

INSERT INTO `kos_facilities` (`kos_id`, `facility_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(9, 11),
(10, 11),
(11, 11),
(12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint UNSIGNED NOT NULL,
  `kos_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `converted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `kos_id`, `user_id`, `ip_address`, `user_agent`, `converted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-21 20:50:50', '2026-05-29 20:50:50'),
(2, 1, 8, '172.16.0.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-07 20:50:50', '2026-05-29 20:50:50'),
(3, 1, 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-15 20:50:50', '2026-05-29 20:50:50'),
(4, 2, 7, '172.16.0.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-01 20:50:50', '2026-05-29 20:50:50'),
(5, 2, 8, '172.16.0.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-16 20:50:50', '2026-05-29 20:50:50'),
(6, 2, 8, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-06 20:50:50', '2026-05-29 20:50:50'),
(7, 3, 7, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-12 20:50:50', '2026-05-29 20:50:50'),
(8, 3, 7, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-10 20:50:50', '2026-05-29 20:50:50'),
(9, 3, 8, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-26 20:50:50', '2026-05-29 20:50:50'),
(10, 4, 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-24 20:50:50', '2026-05-29 20:50:50'),
(11, 4, 7, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-06 20:50:50', '2026-05-29 20:50:50'),
(12, 4, 8, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-04 20:50:50', '2026-05-29 20:50:50'),
(13, 5, 8, '172.16.0.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-04 20:50:50', '2026-05-29 20:50:50'),
(14, 5, 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-27 20:50:50', '2026-05-29 20:50:50'),
(15, 5, 8, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-01 20:50:50', '2026-05-29 20:50:50'),
(16, 6, 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-21 20:50:50', '2026-05-29 20:50:50'),
(17, 6, 7, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-04 20:50:50', '2026-05-29 20:50:50'),
(18, 6, 8, '172.16.0.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-28 20:50:50', '2026-05-29 20:50:50'),
(19, 7, 7, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-04-30 20:50:50', '2026-05-29 20:50:50'),
(20, 7, 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-28 20:50:50', '2026-05-29 20:50:50'),
(21, 7, 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-07 20:50:50', '2026-05-29 20:50:50'),
(22, 8, 7, '10.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-13 20:50:50', '2026-05-29 20:50:50'),
(23, 8, 7, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-25 20:50:50', '2026-05-29 20:50:50'),
(24, 8, 7, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', NULL, '2026-05-25 20:50:50', '2026-05-29 20:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `local_businesses`
--

CREATE TABLE `local_businesses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('laundry','catering','internet','moving_service','minimarket','pharmacy','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whatsapp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `local_businesses`
--

INSERT INTO `local_businesses` (`id`, `user_id`, `name`, `slug`, `category`, `description`, `whatsapp`, `phone`, `address`, `latitude`, `longitude`, `image_url`, `is_verified`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Laundry Kiloan Sehat', 'laundry-kiloan-sehat', 'laundry', 'Laundry kiloan cepat dan bersih. Gratis antar jemput untuk area kos sekitar.', '6281234568001', NULL, 'Jl. Pancing No. 5, Medan', 3.59850000, 98.68120000, NULL, 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(2, 3, 'Warung Makan Bu Tini', 'warung-makan-bu-tini', 'catering', 'Catering masakan rumahan dengan harga terjangkau. Menu harian dan mingguan.', '6281234568002', NULL, 'Jl. Sisingamangaraja No. 15, Medan', 3.59120000, 98.67560000, NULL, 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(3, 4, 'Internet WiFi Cepat', 'internet-wifi-cepat', 'internet', 'Paket internet unlimited untuk kos. Instalasi gratis dan support 24 jam.', '6281234568003', NULL, 'Jl. HM Jhoni No. 20, Medan', 3.59410000, 98.67120000, NULL, 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 5, 'Jasa Pindahan Aman', 'jasa-pindahan-aman', 'moving_service', 'Jasa pindahan khusus kos mahasiswa. Harga bersahabat, hati-hati terhadap barang.', '6281234568004', NULL, 'Jl. Ahmad Yani No. 30, Medan', 3.58760000, 98.66980000, NULL, 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(5, 6, 'Apotek Sehat', 'apotek-sehat', 'pharmacy', 'Apotek lengkap dengan obat-obatan umum. Buka 24 jam untuk kebutuhan darurat.', '6281234568005', NULL, 'Jl. Sudirman No. 50, Medan', 3.58940000, 98.67310000, NULL, 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_add_user_fields', 1),
(5, '2024_01_01_000002_create_kos_table', 1),
(6, '2024_01_01_000003_create_facilities_table', 1),
(7, '2024_01_01_000004_create_kos_facilities_table', 1),
(8, '2024_01_01_000005_create_photos_table', 1),
(9, '2024_01_01_000006_create_reviews_table', 1),
(10, '2024_01_01_000007_create_leads_table', 1),
(11, '2024_01_01_000008_create_ads_table', 1),
(12, '2024_01_01_000009_create_local_businesses_table', 1),
(13, '2024_01_01_000010_create_notifications_table', 1),
(14, '2024_01_01_000011_create_reports_table', 1),
(15, '2024_01_01_000012_add_fields_to_reports_table', 1),
(16, '2024_01_01_000013_create_bookings_table', 1),
(17, '2026_05_29_040951_create_personal_access_tokens_table', 1),
(18, '2024_06_01_000001_add_booking_profile_fields', 2),
(19, '2026_06_02_000001_add_presence_columns_to_users_table', 3),
(20, '2026_06_02_000002_add_status_to_reviews_table', 4),
(21, '2026_06_05_000001_fix_reviews_is_visible_default', 5),
(22, '2026_06_09_000001_create_favorite_kos_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'booking', 'Booking Baru', 'Muhammad Alvin NurRahman mengajukan booking untuk Kos Icikiwir', '{\"kos_id\": 10, \"status\": \"pending\", \"kos_slug\": \"kos-icikiwir\", \"booking_id\": 3, \"mahasiswa_id\": 9, \"move_in_date\": \"2026-06-01\", \"mahasiswa_name\": \"Muhammad Alvin NurRahman\", \"duration_months\": \"6\", \"mahasiswa_phone\": \"81376448988\", \"mahasiswa_gender\": \"L\", \"mahasiswa_university\": \"Universitas Islam Negeri Sumatera Utara\"}', 1, '2026-06-01 10:44:46', '2026-06-01 09:38:03', '2026-06-01 10:44:46'),
(3, 2, 'kos_approved', 'Kos Diterima! 🎉', 'Properti kos \'Kos Icikiwir\' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.', '{\"kos_id\": 10, \"status\": \"active\", \"kos_name\": \"Kos Icikiwir\", \"kos_slug\": \"kos-icikiwir\"}', 1, '2026-06-09 08:37:39', '2026-06-01 12:03:59', '2026-06-09 08:37:39'),
(4, 2, 'kos_approved', 'Kos Diterima! 🎉', 'Properti kos \'Kos Aselole\' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.', '{\"kos_id\": 9, \"status\": \"active\", \"kos_name\": \"Kos Aselole\", \"kos_slug\": \"kos-aselole\"}', 1, '2026-06-09 08:37:39', '2026-06-01 12:14:36', '2026-06-09 08:37:39'),
(5, 2, 'kos_approved', 'Kos Diterima! 🎉', 'Properti kos \'Kos Aselole\' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.', '\"{\\\"kos_id\\\":9,\\\"kos_slug\\\":\\\"kos-aselole\\\"}\"', 1, '2026-06-09 08:37:39', '2026-06-01 12:14:45', '2026-06-09 08:37:39'),
(6, 2, 'kos_approved', 'Kos Diterima! 🎉', 'Properti kos \'Kos Icikiwir\' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.', '{\"kos_id\": 10, \"status\": \"active\", \"kos_name\": \"Kos Icikiwir\", \"kos_slug\": \"kos-icikiwir\"}', 1, '2026-06-09 08:37:39', '2026-06-01 12:14:58', '2026-06-09 08:37:39'),
(7, 2, 'kos_approved', 'Kos Diterima! 🎉', 'Properti kos \'Kos Digidaw\' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.', '{\"kos_id\": 12, \"status\": \"active\", \"kos_name\": \"Kos Digidaw\", \"kos_slug\": \"kos-digidaw\"}', 1, '2026-06-09 08:37:39', '2026-06-02 01:30:09', '2026-06-09 08:37:39'),
(8, 2, 'booking', 'Booking Baru', 'Muhammad Alvin Nurrahman mengajukan booking untuk Kos Jomok(erto)', '{\"kos_id\": 11, \"status\": \"pending\", \"kos_slug\": \"kos-jomokerto\", \"booking_id\": 4, \"mahasiswa_id\": 10, \"move_in_date\": \"2026-06-09\", \"mahasiswa_name\": \"Muhammad Alvin Nurrahman\", \"duration_months\": \"6\", \"mahasiswa_phone\": \"081376448988\", \"mahasiswa_gender\": \"L\", \"mahasiswa_university\": \"Universitas Islam Negeri Sumatera Utara\"}', 1, '2026-06-09 08:37:39', '2026-06-09 06:26:05', '2026-06-09 08:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('vinnr21@gmail.com', '$2y$12$UC9ElgLIv0HKRy6ESv1SFemrYz60xN1vyA2rAlixhIcHWEFmFFrSe', '2026-06-02 22:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` bigint UNSIGNED NOT NULL,
  `kos_id` bigint UNSIGNED NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `kos_id`, `url`, `order`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://picsum.photos/seed/1_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(2, 1, 'https://picsum.photos/seed/1_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(3, 1, 'https://picsum.photos/seed/1_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 2, 'https://picsum.photos/seed/2_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(5, 2, 'https://picsum.photos/seed/2_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(6, 2, 'https://picsum.photos/seed/2_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(7, 3, 'https://picsum.photos/seed/3_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(8, 3, 'https://picsum.photos/seed/3_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(9, 3, 'https://picsum.photos/seed/3_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(10, 4, 'https://picsum.photos/seed/4_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(11, 4, 'https://picsum.photos/seed/4_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(12, 4, 'https://picsum.photos/seed/4_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(13, 5, 'https://picsum.photos/seed/5_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(14, 5, 'https://picsum.photos/seed/5_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(15, 5, 'https://picsum.photos/seed/5_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(16, 6, 'https://picsum.photos/seed/6_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(17, 6, 'https://picsum.photos/seed/6_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(18, 6, 'https://picsum.photos/seed/6_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(19, 7, 'https://picsum.photos/seed/7_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(20, 7, 'https://picsum.photos/seed/7_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(21, 7, 'https://picsum.photos/seed/7_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(22, 8, 'https://picsum.photos/seed/8_1/800/600', 1, 1, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(23, 8, 'https://picsum.photos/seed/8_2/800/600', 2, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(24, 8, 'https://picsum.photos/seed/8_3/800/600', 3, 0, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(25, 9, 'kos-photos/1D09W67mW2rY8LcCSv9EQBIDBoeZweBX5Bw85iOJ.png', 0, 1, '2026-05-31 18:51:48', '2026-05-31 18:51:48'),
(26, 9, 'kos-photos/HngZRwKpRqTBMFFEFkKWpJSR01M1bPMN3olGJuIq.png', 1, 0, '2026-05-31 18:51:48', '2026-05-31 18:51:48'),
(27, 9, 'kos-photos/ScIscIerNLQExRQEEzN4PGZ0zXQtntfaSnubYWlA.png', 2, 0, '2026-05-31 18:51:48', '2026-05-31 18:51:48'),
(28, 9, 'kos-photos/CnexmPtKowz6SQZuQN6uZUbzUvuvFoe3k7z9GoEC.png', 3, 0, '2026-05-31 18:51:48', '2026-05-31 18:51:48'),
(29, 9, 'kos-photos/SpzYoX6ALqhYUkkjnYsVulleYGxPPWyhkufxhTcG.png', 4, 0, '2026-05-31 18:51:48', '2026-05-31 18:51:48'),
(30, 10, 'kos-photos/KZwy7rKovIr9gLuufxBV5L3SZ31AvD6nsx7k1cu9.png', 0, 1, '2026-05-31 20:25:42', '2026-05-31 20:25:42'),
(31, 10, 'kos-photos/Q6kqNKtHlihjgKpKYcJPcROfjay56g7IT8a3C1kl.png', 1, 0, '2026-05-31 20:25:42', '2026-05-31 20:25:42'),
(32, 10, 'kos-photos/H9VQs8l0bBibUzJU5aTdvaUa0djpvj7I85Agv9gK.png', 2, 0, '2026-05-31 20:25:42', '2026-05-31 20:25:42'),
(33, 10, 'kos-photos/xOsTahPZDSNCTolUTcNJATRwQPJinqwvBes0Qwnz.png', 3, 0, '2026-05-31 20:25:42', '2026-05-31 20:25:42'),
(34, 10, 'kos-photos/0p50GfAZ5S9HG4dMBZEZSvJp0c8uTcd62Pnvf7FX.png', 4, 0, '2026-05-31 20:25:42', '2026-05-31 20:25:42'),
(35, 11, 'kos-photos/lnmQ0c14oiG5YPrAhqBEIMi0oLLxUdN3YuOzE1aX.jpg', 0, 1, '2026-06-01 09:42:57', '2026-06-01 09:42:57'),
(36, 11, 'kos-photos/moIOW7yBPM7K9vgbfy12TOitO0uZYTTzpYcBeu4p.jpg', 1, 0, '2026-06-01 09:42:57', '2026-06-01 09:42:57'),
(37, 11, 'kos-photos/JzLSetrY22C5ZLNcZV060Jf8APU3a2SjbnM5jXQM.jpg', 2, 0, '2026-06-01 09:42:57', '2026-06-01 09:42:57'),
(38, 12, 'kos-photos/YLEdxLBbbY4Vva7rKsuSd88y1eCf16gA2Xh87HBU.jpg', 0, 1, '2026-06-02 01:29:05', '2026-06-02 01:29:05'),
(39, 12, 'kos-photos/OGbnIQs08DsO6h9fIAKPs3OJ9XzJWvLYktSlTTlq.jpg', 1, 0, '2026-06-02 01:29:05', '2026-06-02 01:29:05'),
(40, 12, 'kos-photos/Yb1ZIVi2tGLPc08uKkG8PFdznzyO2zU9S6Dxhfmq.jpg', 2, 0, '2026-06-02 01:29:05', '2026-06-02 01:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type_id` bigint UNSIGNED NOT NULL,
  `reportable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','reviewed','resolved','dismissed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_types`
--

CREATE TABLE `report_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_types`
--

INSERT INTO `report_types` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Data Tidak Akurat', 'inaccurate', 'Informasi kos tidak sesuai dengan kenyataan', '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(2, 'Review Palsu', 'fake', 'Review yang diragukan kebenarannya', '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(3, 'Konten Tidak Pantas', 'inappropriate', 'Konten yang mengandung SARA atau tidak pantas', '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 'Spam', 'spam', 'Konten spam atau tidak relevan', '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(5, 'Lainnya', 'other', 'Laporan lainnya', '2026-05-29 20:50:50', '2026-05-29 20:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `kos_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `rating_cleanliness` int DEFAULT NULL,
  `rating_security` int DEFAULT NULL,
  `rating_facilities` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `helpful_count` int NOT NULL DEFAULT '0',
  `is_flagged` tinyint(1) NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `moderated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moderated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `kos_id`, `user_id`, `rating`, `rating_cleanliness`, `rating_security`, `rating_facilities`, `comment`, `helpful_count`, `is_flagged`, `is_visible`, `status`, `rejection_reason`, `moderated_by`, `moderated_at`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 5, 4, 5, 4, 'Pemilik kos sangat helpful dan mau membantu kalau ada masalah. Recomended!', 0, 0, 1, 'approved', NULL, '1', '2026-06-02 09:40:38', '2026-05-29 20:50:50', '2026-06-02 09:40:38'),
(2, 1, 8, 4, 5, 5, 3, 'Keamanan terjamin dengan akses kartu dan CCTV. Parkir luas untuk motor maupun mobil.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(3, 2, 7, 4, 5, 4, 4, 'Nyaman untuk belajar. Suasana tenang dan tidak bising. WiFi juga kencang untuk kerja.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(4, 2, 8, 5, 5, 5, 3, 'Sudah tinggal 3 bulan di sini, sangat puas. Kamar mandi selalu bersih dan tidak ada masalah.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(5, 3, 7, 5, 5, 4, 5, 'Pemilik kos sangat helpful dan mau membantu kalau ada masalah. Recomended!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(6, 3, 8, 5, 4, 4, 4, 'Kos sangat nyaman dan bersih. Pemilik ramah dan responsif. Sangat direkomendasikan!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(7, 4, 7, 4, 4, 4, 3, 'Kos sangat nyaman dan bersih. Pemilik ramah dan responsif. Sangat direkomendasikan!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(8, 4, 8, 5, 5, 5, 4, 'Pemilik kos sangat helpful dan mau membantu kalau ada masalah. Recomended!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(9, 5, 7, 5, 4, 5, 3, 'Lokasi strategis dan fasilitas lengkap. Harga sesuai dengan kualitas. Mantap!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(10, 5, 8, 4, 5, 5, 3, 'Lokasi strategis dan fasilitas lengkap. Harga sesuai dengan kualitas. Mantap!', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(11, 6, 7, 4, 5, 5, 3, 'Keamanan terjamin dengan akses kartu dan CCTV. Parkir luas untuk motor maupun mobil.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(12, 6, 8, 5, 4, 4, 5, 'Kamar luas dengan AC yang dingin. WiFi cepat dan stabil. Lingkungan aman dan tenang.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(13, 7, 7, 5, 4, 5, 5, 'Sudah tinggal 3 bulan di sini, sangat puas. Kamar mandi selalu bersih dan tidak ada masalah.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(14, 7, 8, 5, 4, 4, 3, 'Sudah tinggal 3 bulan di sini, sangat puas. Kamar mandi selalu bersih dan tidak ada masalah.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(15, 8, 7, 5, 4, 5, 3, 'Nyaman untuk belajar. Suasana tenang dan tidak bising. WiFi juga kencang untuk kerja.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(16, 8, 8, 4, 4, 5, 4, 'Pelayanan sangat baik. Pemilik fast response. Kos-nya sesuai dengan foto di aplikasi.', 0, 0, 1, 'pending', NULL, NULL, NULL, '2026-05-29 20:50:50', '2026-05-29 20:50:50'),
(17, 11, 10, 5, 5, 5, 4, 'Nyaman, Aman sentosa, tentram.', 0, 0, 1, 'approved', NULL, '1', '2026-06-09 10:06:32', '2026-06-09 07:19:57', '2026-06-09 10:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('B9KFOZn00sCgMmVHIOAcKtYxTbSaNdKV40z9ox3R', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4d1MwOW5WYmNOaGpPaDFOaWN5Q1VzZjRWRGQ2SHAxVGVVcGNGWXFLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2NoZWNra29zLnRlc3QiLCJyb3V0ZSI6ImhvbWUifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwidXNlcl9pZCI6MSwidXNlcl9uYW1lIjoiQWRtaW4gS29zQ2hlY2siLCJ1c2VyX2VtYWlsIjoiYWRtaW5Aa29zY2hlY2suaWQiLCJ1c2VyX3JvbGUiOiJhZG1pbiIsInVzZXJfaW5zdGl0dXRpb24iOm51bGwsInVzZXJfcGhvbmUiOm51bGx9', 1781030112),
('obLybZWrLkWmtSBE8DEBrkYiCk0H9ULHpvxcCo7G', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuQVRSSlBoRUhSTXdlWjd1N1dhZWRlMFhmNzJmNm9lemh1VGluMXJKIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluIiwicm91dGUiOiJhZG1pbiJ9LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwidXNlcl9pZCI6MSwidXNlcl9uYW1lIjoiQWRtaW4gS29zQ2hlY2siLCJ1c2VyX2VtYWlsIjoiYWRtaW5Aa29zY2hlY2suaWQiLCJ1c2VyX3JvbGUiOiJhZG1pbiIsInVzZXJfaW5zdGl0dXRpb24iOm51bGwsInVzZXJfcGhvbmUiOm51bGx9', 1781027600),
('XZ0f4OCyBwNHsvXcQWmt0vFLENeRsWLOHUebn3Y3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlb2VhUzVvNDBhTVdUcUM2MnJlV3pQZnhxTHdrck4wYnd4ZzBRbjAxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2NoZWNra29zLnRlc3QiLCJyb3V0ZSI6ImhvbWUifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781028514);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('mahasiswa','owner','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `university` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `university`, `phone`, `avatar`, `is_active`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_seen_at`) VALUES
(1, 'Admin KosCheck', 'admin@koscheck.id', '2026-05-29 20:50:46', '$2y$12$5rbyuSxPAKIwRNpBADeMfuNpVw5fp8qb7nH1o/QdQluFa/4DOqwbe', 'admin', NULL, NULL, NULL, 1, NULL, '2026-05-29 20:50:46', '2026-06-09 11:27:54', '2026-06-09 11:27:54', '2026-06-09 11:27:54'),
(2, 'Budi Santoso', 'owner@email.com', '2026-05-29 20:50:46', '$2y$12$UZ.c74g466wO8.AHxk5QuuRe42ik9mvxulaVZ6Ouzibx/WyYBbez2', 'owner', NULL, '081234567890', NULL, 1, NULL, '2026-05-29 20:50:46', '2026-06-09 10:05:09', '2026-06-09 08:17:42', '2026-06-09 10:05:09'),
(3, 'Siti Rahayu', 'siti.owner@email.com', '2026-05-29 20:50:47', '$2y$12$NxDCv2V7DyYe1F/dx9CCm.nCeKuxoL1fEaQeQW52dOa2P.p8114n.', 'owner', NULL, '081234567891', NULL, 1, NULL, '2026-05-29 20:50:47', '2026-05-29 20:50:47', NULL, NULL),
(4, 'Ahmad Fauzi', 'ahmad.owner@email.com', '2026-05-29 20:50:47', '$2y$12$JUm8cmIaLWPFxl5nV9niS.o/3eUpLqhAfZ5HmZK3619q2guoqkLl.', 'owner', NULL, '081234567892', NULL, 1, NULL, '2026-05-29 20:50:47', '2026-05-29 20:50:47', NULL, NULL),
(5, 'Rina Wulandari', 'rina.owner@email.com', '2026-05-29 20:50:48', '$2y$12$iSZRozDMqRSNgVULnSi98.DY3WnttQFjUW9IixZ5ycq5mVY790vn2', 'owner', NULL, '081234567893', NULL, 1, NULL, '2026-05-29 20:50:48', '2026-05-29 20:50:48', NULL, NULL),
(6, 'Dedi Kurniawan', 'dedi.owner@email.com', '2026-05-29 20:50:48', '$2y$12$R8F8mNKaH6a8k2VPJq5bneV4pQ65vqpJ4P0VbNrrVvrsAlly6SYXq', 'owner', NULL, '081234567894', NULL, 1, NULL, '2026-05-29 20:50:48', '2026-05-29 20:50:48', NULL, NULL),
(7, 'Andi Wijaya', 'mahasiswa@usu.ac.id', '2026-05-29 20:50:49', '$2y$12$ekR5qPpg19dZYaOlnw52LeKbkf3iZSJd9ft9E89G2PZ1s8nRdEPsi', 'mahasiswa', 'Universitas Sumatera Utara', NULL, NULL, 1, NULL, '2026-05-29 20:50:49', '2026-06-09 05:45:48', '2026-06-09 05:45:48', '2026-06-09 05:45:48'),
(8, 'Dewi Lestari', 'dewi@unimed.ac.id', '2026-05-29 20:50:49', '$2y$12$ovCL33kpzJPj7Kv1LiXBbu5No5C1I8eeX6yoL/B5tK7fe6vyUAplG', 'mahasiswa', 'Universitas Negeri Medan', NULL, NULL, 1, NULL, '2026-05-29 20:50:49', '2026-06-02 09:36:35', '2026-06-02 09:36:35', '2026-06-02 09:36:35'),
(10, 'Muhammad Alvin Nurrahman', 'vinnr21@gmail.com', NULL, '$2y$12$QlkR4kZPgPbPNtCauGiNNuBG4PXofPR7jUHpk4CKt8NGLFXNM3h/O', 'mahasiswa', 'Universitas Islam Negeri Sumatera Utara', '081376448988', NULL, 1, NULL, '2026-06-09 06:24:56', '2026-06-09 06:24:56', '2026-06-09 06:24:56', '2026-06-09 06:24:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_user_id_foreign` (`user_id`),
  ADD KEY `ads_position_is_active_start_date_end_date_index` (`position`,`is_active`,`start_date`,`end_date`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_user_id_kos_id_unique` (`user_id`,`kos_id`),
  ADD KEY `bookings_status_index` (`status`),
  ADD KEY `bookings_kos_id_status_index` (`kos_id`,`status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facilities_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorite_kos`
--
ALTER TABLE `favorite_kos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorite_kos_user_id_kos_id_unique` (`user_id`,`kos_id`),
  ADD KEY `favorite_kos_user_id_index` (`user_id`),
  ADD KEY `favorite_kos_kos_id_index` (`kos_id`);

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
-- Indexes for table `kos`
--
ALTER TABLE `kos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kos_slug_unique` (`slug`),
  ADD KEY `kos_user_id_foreign` (`user_id`),
  ADD KEY `kos_is_premium_created_at_index` (`is_premium`,`created_at`),
  ADD KEY `kos_gender_index` (`gender`),
  ADD KEY `kos_price_index` (`price`),
  ADD KEY `kos_is_active_index` (`is_active`);

--
-- Indexes for table `kos_facilities`
--
ALTER TABLE `kos_facilities`
  ADD PRIMARY KEY (`kos_id`,`facility_id`),
  ADD KEY `kos_facilities_facility_id_foreign` (`facility_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_user_id_foreign` (`user_id`),
  ADD KEY `leads_kos_id_created_at_index` (`kos_id`,`created_at`),
  ADD KEY `leads_ip_address_kos_id_created_at_index` (`ip_address`,`kos_id`,`created_at`);

--
-- Indexes for table `local_businesses`
--
ALTER TABLE `local_businesses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `local_businesses_slug_unique` (`slug`),
  ADD KEY `local_businesses_user_id_foreign` (`user_id`),
  ADD KEY `local_businesses_category_is_active_index` (`category`,`is_active`),
  ADD KEY `local_businesses_latitude_longitude_index` (`latitude`,`longitude`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_kos_id_foreign` (`kos_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_report_id_unique` (`report_id`),
  ADD KEY `reports_report_type_id_foreign` (`report_type_id`),
  ADD KEY `reports_reportable_type_reportable_id_index` (`reportable_type`,`reportable_id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `reports_status_index` (`status`);

--
-- Indexes for table `report_types`
--
ALTER TABLE `report_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_types_slug_unique` (`slug`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_kos_id_user_id_unique` (`kos_id`,`user_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_is_flagged_index` (`is_flagged`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_kos`
--
ALTER TABLE `favorite_kos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kos`
--
ALTER TABLE `kos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `local_businesses`
--
ALTER TABLE `local_businesses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_types`
--
ALTER TABLE `report_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorite_kos`
--
ALTER TABLE `favorite_kos`
  ADD CONSTRAINT `favorite_kos_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorite_kos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kos`
--
ALTER TABLE `kos`
  ADD CONSTRAINT `kos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kos_facilities`
--
ALTER TABLE `kos_facilities`
  ADD CONSTRAINT `kos_facilities_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kos_facilities_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `local_businesses`
--
ALTER TABLE `local_businesses`
  ADD CONSTRAINT `local_businesses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_report_type_id_foreign` FOREIGN KEY (`report_type_id`) REFERENCES `report_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_kos_id_foreign` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
