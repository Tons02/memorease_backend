-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2025 at 12:42 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memorease`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cemeteries`
--

CREATE TABLE `cemeteries` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinates` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cemeteries`
--

INSERT INTO `cemeteries` (`id`, `profile_picture`, `name`, `description`, `location`, `coordinates`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cemeteries/kj5ZYCwejEQjy6zYeLZSRf3hIsBOLbi5ywGNrGV3.jpg', 'Providence Memorial park 1', 'Sample description 2', 'Dasma Cavite', '14.288794, 120.970325', NULL, '2025-08-30 17:47:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversation_user`
--

CREATE TABLE `conversation_user` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `last_read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversation_users`
--

CREATE TABLE `conversation_users` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `last_read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deceased`
--

CREATE TABLE `deceased` (
  `id` bigint UNSIGNED NOT NULL,
  `lot_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_id` bigint UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `death_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `death_certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deceased`
--

INSERT INTO `deceased` (`id`, `lot_image`, `lot_id`, `fname`, `mname`, `lname`, `suffix`, `gender`, `birthday`, `death_date`, `death_certificate`, `is_private`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'lot_image/V5IICvna3eFYQfT5h61dBNCDlDI0e5gNJm4PGCq3.jpg', 5, 'Jose', NULL, 'Rizal', NULL, 'male', '1985-08-15', '2002-07-17', 'death_certificate/2U03cWBSkDcWARVYu05pzEBYvtHz3MY17X2gFeVO.jpg', 0, '2025-08-30 06:06:20', '2025-08-30 06:06:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` bigint UNSIGNED NOT NULL,
  `lot_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_lot_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third_lot_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourth_lot_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinates` json NOT NULL,
  `status` enum('available','reserved','occupied','sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `reserved_until` datetime DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `downpayment_price` decimal(15,2) DEFAULT NULL,
  `promo_price` decimal(15,2) DEFAULT NULL,
  `promo_until` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `lot_image`, `second_lot_image`, `third_lot_image`, `fourth_lot_image`, `lot_number`, `description`, `coordinates`, `status`, `reserved_until`, `price`, `downpayment_price`, `promo_price`, `promo_until`, `is_featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'lot/4GwCRHgB7I7J7pGglGCOS8VjoxUxySB36bXS2iZk.jpg', 'lot/8vzLMY2spXeKa6EwnFOJhbQMcyOHv5qDUI26DXE7.jpg', 'lot/hmMLuGNwsgSBDUgFHmERoaWQzlrMiVH0RQt8ru78.jpg', NULL, 'Lot 1', 'Testing Description', '[[14.287236497024889, 120.97154291351666], [14.287241698568668, 120.97161802595092], [14.287194884670178, 120.97162339112484], [14.287184481580304, 120.97154023092976]]', 'available', NULL, '20000.00', '2000.00', NULL, NULL, 0, '2025-08-30 05:49:42', '2025-08-30 05:58:27', NULL),
(2, 'lot/7UC0JKUCg3C5AS4Ay1oHcKxArw0TvfpBK4AqelY3.jpg', 'lot/a2yTqM437oSGNCsAADxSoYL0GZ2f0kVIbCI22ScY.jpg', NULL, NULL, 'Lot 2', 'Testing', '[[14.287161190274048, 120.9715482726438], [14.287176794910312, 120.9716341154258], [14.287129980998287, 120.9716341154258], [14.287111775585425, 120.9715616855785]]', 'available', NULL, '40000.00', '4000.00', NULL, NULL, 0, '2025-08-30 05:50:06', '2025-08-30 05:50:06', NULL),
(3, 'lot/19xbYKYA4GjA6WGpPcd9uOCq8vUqeTjm0ZajjSVy.jpg', 'lot/Xidn6oPSSeoEFX2Gg5vr5YLdpg4Ud5eESpGDp88l.jpg', NULL, NULL, 'Lot 3', 'Testing lnag ito', '[[14.287083167076554, 120.97155632040456], [14.28710137249172, 120.97161801990416], [14.287057159338024, 120.97162338507805], [14.28703895391927, 120.9715643681654]]', 'available', NULL, '30000.00', '3000.00', NULL, NULL, 0, '2025-08-30 05:50:33', '2025-08-30 05:50:33', NULL),
(4, 'lot/lD1JWnmet5rwdHVd4HJzYvyUlQSQMFHd7oNcFdNc.jpg', 'lot/BWUo38pYXjridJNMqkCgq2exbqU1rsyyPJotnPEp.jpg', NULL, NULL, 'Lot 4', 'Testing', '[[14.287031151596512, 120.97156973333932], [14.287046756241784, 120.97162875025194], [14.287002543077364, 120.97162875025194], [14.286984337654197, 120.9715724159262]]', 'reserved', NULL, '20000.00', '2500.00', NULL, NULL, 0, '2025-08-30 05:51:01', '2025-08-30 06:00:58', NULL),
(5, 'lot/RTlfUWvRuOiylqKcRC94yf7LGXvBMl5Fr5HPgVrE.jpg', 'lot/J2mx3Is24SXRZ2LCzPqlAcvWnkK76vIG22qENWgI.jpg', NULL, NULL, 'Lot 5', 'Testing Description', '[[14.286968733004583, 120.97158046368703], [14.286981736879328, 120.97162875025194], [14.286927120600362, 120.9716341154258], [14.2869193182737, 120.9715858288609]]', 'sold', NULL, '50000.00', '6000.00', NULL, NULL, 0, '2025-08-30 05:51:26', '2025-08-30 05:59:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_statuses`
--

CREATE TABLE `message_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `message_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('sent','delivered','read') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_users_table', 1),
(2, '0001_01_01_000002_create_cache_table', 1),
(3, '0001_01_01_000003_create_jobs_table', 1),
(4, '2025_06_21_114838_create_cemeteries_table', 1),
(5, '2025_06_21_114857_create_lots_table', 1),
(9, '2025_06_21_131219_create_personal_access_tokens_table', 1),
(11, '2025_06_21_114906_create_reservations_table', 2),
(12, '2025_06_21_114927_create_deceased_table', 2),
(13, '2025_06_21_124054_create_reservation_payments_table', 2),
(14, '2025_07_30_004353_create_conversations_table', 3),
(15, '2025_07_30_004409_create_conversation_users_table', 3),
(16, '2025_07_30_004424_create_messages_table', 3),
(17, '2025_07_30_004441_create_message_statuses_table', 3),
(18, '2025_07_30_005644_create_conversation_user_table', 3),
(19, '2025_08_30_015344_create_terms_and_agreements_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'admin', '94c41aaf92730d835f47a7bb62fd7579a210360975bdbebc4f9ae21a8cb60a82', '[\"admin\"]', '2025-07-05 04:09:57', NULL, '2025-07-04 16:27:30', '2025-07-05 04:09:57'),
(6, 'App\\Models\\User', 1, 'admin', '6e3d037421eeb318d2825aa5dc027fa321f92b9df930a756e3ece90eaa8a5852', '[\"admin\"]', '2025-07-19 03:44:11', NULL, '2025-07-18 18:01:15', '2025-07-19 03:44:11'),
(13, 'App\\Models\\User', 3, 'admin', 'bdfe3db9c162745a2e0eec36c3630c67cbe01b0408321e8bdbb1be740234186f', '[\"admin\"]', NULL, NULL, '2025-07-19 04:18:17', '2025-07-19 04:18:17'),
(15, 'App\\Models\\User', 1, 'admin', 'b815383c816a9b0e510d671e52126d4f7ddf0edcafe512b2ac960cbe120c4e61', '[\"admin\"]', '2025-07-19 04:43:36', NULL, '2025-07-19 04:43:24', '2025-07-19 04:43:36'),
(19, 'App\\Models\\User', 1, 'admin', '7870d9b474db27509a08e9d10e0b498ba96d1f2b397b2b93cbfc188ba6c37ea9', '[\"admin\"]', '2025-08-01 20:32:02', NULL, '2025-07-19 05:48:32', '2025-08-01 20:32:02'),
(21, 'App\\Models\\User', 4, 'customer', 'ce44d161a5f025b8fb4e2bb524548cff3247fb26c7297c9c382e2e205a275041', '[\"customer\"]', NULL, NULL, '2025-07-19 06:05:45', '2025-07-19 06:05:45'),
(22, 'App\\Models\\User', 4, 'customer', 'b17e56d9a3c44717e048272af99e12f0863c5de650f547a13a267e93360c5ce4', '[\"customer\"]', '2025-07-25 05:17:51', NULL, '2025-07-25 05:17:32', '2025-07-25 05:17:51'),
(24, 'App\\Models\\User', 1, 'admin', '2dafe6eaa098b1e4218e5c441de62030ce5dd3ec244083b5551f48e062540665', '[\"admin\"]', '2025-07-31 05:59:17', NULL, '2025-07-31 05:27:41', '2025-07-31 05:59:17'),
(26, 'App\\Models\\User', 5, 'customer', '7f90c41d412b39b490c952bdeca85f00393c11d429c94603510489a376973128', '[\"customer\"]', '2025-07-31 06:25:14', NULL, '2025-07-31 06:07:48', '2025-07-31 06:25:14'),
(28, 'App\\Models\\User', 5, 'admin', '823e8aab1b1047283d0b27c3575fc414b82a69b19a4e6a8beea5e8fea54f1e61', '[\"admin\"]', '2025-08-01 20:27:25', NULL, '2025-08-01 19:16:45', '2025-08-01 20:27:25'),
(29, 'App\\Models\\User', 2, 'admin', '5288c25491159cb3279631b4bfbe998fa675cb570e2fb5ec8ac734da8e277542', '[\"admin\"]', '2025-08-01 20:32:41', NULL, '2025-08-01 20:27:09', '2025-08-01 20:32:41'),
(30, 'App\\Models\\User', 4, 'admin', 'f59766097250edd6d904290282fe2647731ff3ebfb7ced8c25420443607d64fb', '[\"admin\"]', '2025-08-01 20:59:03', NULL, '2025-08-01 20:31:59', '2025-08-01 20:59:03'),
(32, 'App\\Models\\User', 2, 'admin', '7bf7739ba11ad1e0486c1e7455abb6aa1f7a704ea7cef5007ff814642f7ee4a8', '[\"admin\"]', '2025-08-03 03:50:27', NULL, '2025-08-01 21:00:09', '2025-08-03 03:50:27'),
(33, 'App\\Models\\User', 1, 'admin', '1f10dd68bb18d71e76a4b89f699a6e259b7dfd391284df16cbfe72a1e4874908', '[\"admin\"]', '2025-08-03 04:10:51', NULL, '2025-08-01 21:03:40', '2025-08-03 04:10:51'),
(34, 'App\\Models\\User', 1, 'admin', 'd35b37a2dac7e711be9b9c076da2cadf41f323c853fabe046acdb530b39e8c76', '[\"admin\"]', '2025-08-02 18:36:05', NULL, '2025-08-02 18:34:55', '2025-08-02 18:36:05'),
(35, 'App\\Models\\User', 2, 'admin', '8b57fc5d2d475d671fe6ed7b1a3ad2b874337ffb928a7867c4e8df008e19a760', '[\"admin\"]', '2025-08-02 18:46:09', NULL, '2025-08-02 18:44:21', '2025-08-02 18:46:09'),
(36, 'App\\Models\\User', 1, 'admin', '5eed6852fe9626c25a64c91810799ea344117320896ceff58b69e8734058113c', '[\"admin\"]', '2025-08-02 18:46:21', NULL, '2025-08-02 18:45:56', '2025-08-02 18:46:21'),
(37, 'App\\Models\\User', 1, 'admin', 'aadcc39e94fd84cfd7618f22e20e889ad0da2c2f5b77fe2877608911a59d9f16', '[\"admin\"]', '2025-08-03 03:49:59', NULL, '2025-08-03 03:33:51', '2025-08-03 03:49:59'),
(38, 'App\\Models\\User', 1, 'admin', '8b7eca54a38fb32e0256f1b1d3d4bb5e1e7dcb6408a9a6b4a3d0726296ae271f', '[\"admin\"]', '2025-08-03 04:55:06', NULL, '2025-08-03 04:06:35', '2025-08-03 04:55:06'),
(39, 'App\\Models\\User', 2, 'admin', 'cc7b447f6140acf4e70a6ef003571de921509046a6fea404dd4913b9703a9f7f', '[\"admin\"]', '2025-08-03 04:08:36', NULL, '2025-08-03 04:06:57', '2025-08-03 04:08:36'),
(41, 'App\\Models\\User', 3, 'customer', '70c62b77dfcd7801c5327fccef3ee6948f2848cd4e2a34d3ec285bddc587d9e8', '[\"customer\"]', NULL, NULL, '2025-08-08 19:37:14', '2025-08-08 19:37:14'),
(42, 'App\\Models\\User', 3, 'customer', 'f1ae448dbb4e770b389b719e7c5bd35c41bef76f1a03dc6b910d0f27189b8b3c', '[\"customer\"]', NULL, NULL, '2025-08-08 19:38:26', '2025-08-08 19:38:26'),
(43, 'App\\Models\\User', 3, 'customer', 'd52005fd1be02308564be559464683d923b6102ee154fe9a6366a6e6cbde14de', '[\"customer\"]', NULL, NULL, '2025-08-08 19:39:47', '2025-08-08 19:39:47'),
(47, 'App\\Models\\User', 1, 'admin', '4e2b7eef4ca6ab7d4cc5823dcbfe331ffea2a0e89739e582cd744d260c1ccec0', '[\"admin\"]', '2025-08-15 16:13:44', NULL, '2025-08-15 16:01:23', '2025-08-15 16:13:44'),
(49, 'App\\Models\\User', 1, 'admin', 'd600bcaae7d4434e703a099c481d0fd4d7028bba939f9cae5c17461a4a92f4c5', '[\"admin\"]', '2025-08-15 16:10:51', NULL, '2025-08-15 16:10:47', '2025-08-15 16:10:51'),
(51, 'App\\Models\\User', 1, 'admin', '007459c8538846c733d37af8b2b043c23b093ce4788f9a6f647f73dc57896ec7', '[\"admin\"]', '2025-08-15 16:11:31', NULL, '2025-08-15 16:11:06', '2025-08-15 16:11:31'),
(52, 'App\\Models\\User', 2, 'admin', 'b86fe7519d7fee70375033b5db20d07509ab80db8ea703f2035efffe0a9ae679', '[\"admin\"]', '2025-08-15 16:12:58', NULL, '2025-08-15 16:12:53', '2025-08-15 16:12:58'),
(54, 'App\\Models\\User', 1, 'admin', '493bcb84606f2b0b60915a1b74eee89b2de3b4bf4fd7afa95a40a800e2cfeb50', '[\"admin\"]', '2025-08-15 16:13:33', NULL, '2025-08-15 16:13:20', '2025-08-15 16:13:33'),
(55, 'App\\Models\\User', 2, 'admin', '226dddb8f7628e7ba7d7f9173387b2b0e7663698dceaef9a92ec045da1d8f8cb', '[\"admin\"]', '2025-08-15 16:18:15', NULL, '2025-08-15 16:13:39', '2025-08-15 16:18:15'),
(56, 'App\\Models\\User', 2, 'admin', '986a9fd86c41ad0c94c1db061d95a0fbd5e9315d9848c757382c117a18e25d9f', '[\"admin\"]', '2025-08-15 16:16:28', NULL, '2025-08-15 16:16:20', '2025-08-15 16:16:28'),
(57, 'App\\Models\\User', 1, 'admin', '1ad980bc0c045fd4693b3c7a3c6c238b522798f8251b0dd86b907790618d5d6a', '[\"admin\"]', '2025-08-15 16:17:45', NULL, '2025-08-15 16:16:40', '2025-08-15 16:17:45'),
(58, 'App\\Models\\User', 1, 'admin', '454beeec31223c5eba36725c42700fb74f83368edc0736ae42d5063dd527232e', '[\"admin\"]', '2025-08-15 16:18:01', NULL, '2025-08-15 16:17:54', '2025-08-15 16:18:01'),
(59, 'App\\Models\\User', 2, 'admin', '51da8fb2f12659540eb6e5bbcd564e52bb836d1ae3f6f3321c2208d09fd60784', '[\"admin\"]', '2025-08-15 16:32:09', NULL, '2025-08-15 16:18:10', '2025-08-15 16:32:09'),
(60, 'App\\Models\\User', 1, 'admin', '860b3d6a0606c38037ca4ee23c9d849caf3d1c6c866311b1330bcca5f03a7870', '[\"admin\"]', '2025-08-15 16:21:02', NULL, '2025-08-15 16:18:40', '2025-08-15 16:21:02'),
(61, 'App\\Models\\User', 1, 'admin', '47c11e4327db649b3c5e16c109e0c8e81416b999b2f6b2fd02cb0ef725f71862', '[\"admin\"]', '2025-08-15 16:46:31', NULL, '2025-08-15 16:21:27', '2025-08-15 16:46:31'),
(62, 'App\\Models\\User', 2, 'admin', '2158c4f38bdd5ecebf2f3099a2371d0faa0f6ae6bca8ee0bb2e8a963b9f1c312', '[\"admin\"]', '2025-08-16 02:57:44', NULL, '2025-08-15 16:46:04', '2025-08-16 02:57:44'),
(64, 'App\\Models\\User', 1, 'admin', '890812d5f88299e959d039bd4bad620fb5fb2560bbe4c1b339c267f89bfa1498', '[\"admin\"]', '2025-08-15 21:41:34', NULL, '2025-08-15 16:54:19', '2025-08-15 21:41:34'),
(65, 'App\\Models\\User', 3, 'customer', 'db3f4d8a63837d84842cefc6c93480c23cb97d00159979c4668ba576868dd368', '[\"customer\"]', NULL, NULL, '2025-08-15 17:00:41', '2025-08-15 17:00:41'),
(66, 'App\\Models\\User', 1, 'admin', '7d3cd0f9c94c9716fa772f72b9d9d140a1f304ea2a507383a83dc1b50f63f509', '[\"admin\"]', '2025-08-16 03:36:23', NULL, '2025-08-15 21:21:24', '2025-08-16 03:36:23'),
(67, 'App\\Models\\User', 2, 'admin', '8e80571a87a6bbc6c7c98bb4001b4fff8f3940f94aaf5c409e3177b34cfdff86', '[\"admin\"]', '2025-08-15 21:43:09', NULL, '2025-08-15 21:40:35', '2025-08-15 21:43:09'),
(68, 'App\\Models\\User', 2, 'admin', '9443b349aaad3fef6788dfc2579d7be52f6fb3dfb2a9d0d48399176e5e3d58ac', '[\"admin\"]', '2025-08-16 03:16:34', NULL, '2025-08-16 02:57:41', '2025-08-16 03:16:34'),
(69, 'App\\Models\\User', 1, 'admin', 'a002835ecf521c22c448efca1d551c2b87b07f5415e3324ae100a0160ce1e025', '[\"admin\"]', '2025-08-16 04:15:48', NULL, '2025-08-16 03:33:07', '2025-08-16 04:15:48'),
(70, 'App\\Models\\User', 2, 'admin', '99d6e18fd550515588e1398414a785dcac6509e4a463b665971aaa6c2ab610a2', '[\"admin\"]', '2025-08-16 03:35:47', NULL, '2025-08-16 03:33:23', '2025-08-16 03:35:47'),
(72, 'App\\Models\\User', 2, 'admin', '9e6e7c9e763c7844cb468668c49b45f1f6a3272d6298c9077e55d3395a198e29', '[\"admin\"]', '2025-08-16 03:45:59', NULL, '2025-08-16 03:45:45', '2025-08-16 03:45:59'),
(74, 'App\\Models\\User', 1, 'admin', '3bc63ad683bcb12cc6755eb753208ea69cdc6a0252511eae4c4083531d10d503', '[\"admin\"]', '2025-08-16 19:05:05', NULL, '2025-08-16 19:03:40', '2025-08-16 19:05:05'),
(75, 'App\\Models\\User', 1, 'admin', '47eb8ae6a348f07cc2e03eed095496c84aae6ecda124babcc74c363ccbe45737', '[\"admin\"]', '2025-08-16 19:47:50', NULL, '2025-08-16 19:09:26', '2025-08-16 19:47:50'),
(77, 'App\\Models\\User', 7, 'customer', 'c326291224f32f9d017ea4b12d69a57e52e80c6d4d18502808ac254f47f58b21', '[\"customer\"]', '2025-08-16 23:44:39', NULL, '2025-08-16 23:43:26', '2025-08-16 23:44:39'),
(79, 'App\\Models\\User', 8, 'customer', '2c4300f3f1d6ef0f79b5654280c82699d544a7681f44ac0eeb5287eee3d885f5', '[\"customer\"]', '2025-08-17 00:03:54', NULL, '2025-08-16 23:57:30', '2025-08-17 00:03:54'),
(80, 'App\\Models\\User', 1, 'admin', '3bc3d8a507db15ea0e8c1c1fe1257402a4e694bda530d979b833d667ed843c6a', '[\"admin\"]', '2025-08-29 18:45:58', NULL, '2025-08-29 18:11:04', '2025-08-29 18:45:58'),
(81, 'App\\Models\\User', 1, 'admin', 'e06239aa80cc9bf29905a4bcd46bf1398718d1110375b65bb2d5e189f7ec3806', '[\"admin\"]', '2025-08-29 18:45:43', NULL, '2025-08-29 18:44:43', '2025-08-29 18:45:43'),
(84, 'App\\Models\\User', 9, 'customer', '6f15365a7d7d68506ecfd246a56258ee359fc09c49a9cdbf9cbde7b7ad413724', '[\"customer\"]', '2025-08-29 19:43:32', NULL, '2025-08-29 19:32:56', '2025-08-29 19:43:32'),
(86, 'App\\Models\\User', 1, 'admin', 'd457e2a3cc46d024c328f556db42a1f6296b7b9557fffcc677cb323a4a7def90', '[\"admin\"]', '2025-08-29 21:13:53', NULL, '2025-08-29 21:11:50', '2025-08-29 21:13:53'),
(88, 'App\\Models\\User', 1, 'admin', '501abda2148a7a20b93170bffa0d15bf2ed21e3e1051ab65571acd021ab5574d', '[\"admin\"]', '2025-08-30 05:37:52', NULL, '2025-08-29 21:53:29', '2025-08-30 05:37:52'),
(93, 'App\\Models\\User', 1, 'admin', 'd66efcbc7dc61abb2ff22127f46155de4b8ba0f636bcff75ae311200fefa4a7f', '[\"admin\"]', '2025-08-30 17:44:30', NULL, '2025-08-30 17:43:40', '2025-08-30 17:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','expired','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `lot_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_downpayment_price` decimal(15,2) NOT NULL,
  `proof_of_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserved_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT NULL,
  `approved_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `status`, `lot_id`, `user_id`, `total_downpayment_price`, `proof_of_payment`, `remarks`, `reserved_at`, `expires_at`, `paid_at`, `approved_date`, `approved_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'canceled', 1, 9, '2000.00', 'proof_of_payment/9KNaP3rDYZGUgL5ifpcrRDWdzPAxO01Df5ZYZBGc.jpg', NULL, '2025-08-30 05:58:04', '2025-08-31 05:58:04', NULL, NULL, NULL, '2025-08-30 05:58:04', '2025-08-30 05:58:27', NULL),
(2, 'approved', 5, 9, '6000.00', 'proof_of_payment/xPv4jB20GEm6mXxr8OBcFucphjcTnPkIMHhHFI9q.jpg', NULL, '2025-08-30 05:58:51', '2025-08-31 05:58:51', NULL, '2025-08-30 05:59:20', 1, '2025-08-30 05:58:51', '2025-08-30 05:59:20', NULL),
(3, 'pending', 4, 9, '2500.00', 'proof_of_payment/0m4AarVHighgOL19V8RcbPef2EYUVYJxRAnRNq2d.jpg', NULL, '2025-08-30 06:00:58', '2025-08-31 06:00:58', NULL, NULL, NULL, '2025-08-30 06:00:58', '2025-08-30 06:00:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_payments`
--

CREATE TABLE `reservation_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','paid','expired','cancel') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `lot_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reserved_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4zHBrsdOdt0jSwPc2kkzakI3cphyy8YVZTxoZmsZ', NULL, '192.168.100.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT01EU0dIYTl2WXNTVHpWZU9scjJ0Mzhpell2Z09UeExZQ1A5ZVQycCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xOTIuMTY4LjEwMC43Nzo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752891520),
('QZBd0IKKbfuBhrBKvxqxVcEH2h36OjFuQ6sLWZOa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2dWQVRoRHNYVmdtTkhkNHRGTnZ2RXplbkFRSjRkYmxPSGhkVTRQRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754222466);

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_agreements`
--

CREATE TABLE `terms_and_agreements` (
  `id` bigint UNSIGNED NOT NULL,
  `terms` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_and_agreements`
--

INSERT INTO `terms_and_agreements` (`id`, `terms`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '<h1>Terms and agreement</h1><ul><li>bawal mang scam gegi</li><li>bawal utang gagi</li></ul><h1>Terms and agreement</h1><ul><li>bawal mang scam gegi</li><li>bawal utang gagi</li></ul><h1><br></h1>', '2025-08-29 18:11:24', '2025-08-31 04:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_type` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `profile_picture`, `fname`, `mi`, `lname`, `suffix`, `gender`, `mobile_number`, `birthday`, `address`, `username`, `email`, `email_verified_at`, `password`, `role_type`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default_profile.jpg', 'Antonio', 'E', 'Montilla', 'Jr', 'male', '+639168620662', '06-02-2001', 'Pampangas', 'admin', 'testing4512@gmail.com', '2025-08-28 01:34:20', '$2y$12$aG0H8GcwkgTKB9QiJah2Buk3sV36dDScW/TBK5QlWvl3nQhHJV91C', 'admin', NULL, '2025-07-04 16:22:09', '2025-08-16 02:58:40', NULL),
(2, 'default_profile.jpg', 'Magdalena', NULL, 'Magpayo', NULL, 'male', '+639168620123', '19-06-2025', 'Pampanga', 'magdalena', 'magdalena@gmail.com', '2025-08-06 16:00:00', '$2y$12$U1cqGhaHXYCeEnNSfHT3Au90lAwB6cm8NbsC.pnSxy/Bu2LZxZgCG', 'admin', NULL, '2025-07-04 16:51:35', '2025-08-16 03:02:26', NULL),
(3, 'default_profile.jpg', 'Jose', NULL, 'Manalo', NULL, 'male', '+639168620145', '01-07-2025', 'Pampanga', 'tons', 'asdsadsad123@gmail.com', NULL, '$2y$12$aG0H8GcwkgTKB9QiJah2Buk3sV36dDScW/TBK5QlWvl3nQhHJV91C', 'customer', NULL, '2025-07-04 17:52:30', '2025-08-16 03:39:56', NULL),
(4, 'default_profile.jpg', 'Maria', NULL, 'Dela Cruz', 'Jr', 'female', '+639168620299', '02-07-2025', 'Pampangas', 'lhei', 'maria@gmail.com', '2025-08-06 16:00:00', '$2y$12$brXdd1/85FzHkl9OWMjveeJuP.eLr9vGjj7mdmbc4Ak/NhUKyd642', 'admin', NULL, '2025-07-18 17:00:13', '2025-08-16 03:01:09', NULL),
(5, 'default_profile.jpg', 'Jose', NULL, 'Rizal', NULL, 'male', '+639131231666', '11-06-2015', 'Pampanga', 'jose', 'jose@gmail.com', '2025-08-06 16:00:00', '$2y$12$wWY0FLPq.z1rTVdzCrIppepMd6gX.NjhYcbu.VM.LfeZlTYwAae6q', 'admin', NULL, '2025-07-31 05:28:34', '2025-08-16 02:24:16', NULL),
(6, 'default_profile.jpg', 'Antonio', 'D', 'Montilla', NULL, 'male', '+639168616142', '29-04-2025', 'Pampanga', 'antonio', 'testing12322@gmail.com', NULL, '$2y$12$Bc7ErOy1gAu.GSuriw0i3.1GU1f.rpnUMeI6woXNiyq.6Wf.mtrd6', 'customer', NULL, '2025-08-16 23:39:49', '2025-08-29 18:45:38', NULL),
(7, 'default_profile.jpg', 'Antonio', 'D', 'Montilla', 'Jr', 'male', '+639168629146', '01-07-2024', 'Pampanga', 'qwerty', 'testing61@gmail.com', '2025-08-16 23:44:39', '$2y$12$yrlYuXdqHt.jsCLcMNxC7ubJaeEt/U5OHub1mJHQTIqOLDEPDzsxO', 'customer', NULL, '2025-08-16 23:43:23', '2025-08-16 23:56:18', NULL),
(8, 'default_profile.jpg', 'Sample', NULL, 'Test', 'Jr', 'male', '+639168752316', '17-08-1990', 'Pampanga', 'Tonsss', 'testing@gmail.com', '2025-08-17 00:03:54', '$2y$12$hoYFqO27f7Vl4yLloWkFRuBfccPzZBsh1.LQEfDNEu/RjPjLSgkp6', 'customer', NULL, '2025-08-16 23:57:28', '2025-08-17 00:03:54', NULL),
(9, 'default_profile.jpg', 'Antonio', NULL, 'Montilla', 'Jr', 'male', '+639168620212', '02-06-2001', 'Pampanga', 'customer_tons', 'testing323@gmail.com', '2025-08-29 19:33:09', '$2y$12$fCEP1uonozeOH5IzEpWP6eYJ3tbak9CYXaIVdptPf4dJ6174E98YG', 'customer', NULL, '2025-08-29 19:22:18', '2025-08-29 19:39:11', NULL),
(10, 'default_profile.jpg', 'Sample', NULL, 'Testing', NULL, 'male', '+639168620124', '12-08-1999', 'Pampanga', 'admin2', 'testingemail23@gmail.com', '2025-08-30 17:30:05', '$2y$12$R0bBzBUQVmEiHFw9zq5UfeYc2N.WWY4arhViDz9.SbmTxWJ3Gtyty', 'admin', NULL, '2025-08-30 17:30:06', '2025-08-30 17:30:06', NULL),
(11, 'default_profile.jpg', 'Customer', NULL, 'Customer', NULL, 'male', '+639168620166', '04-02-2020', 'Pamapnga', 'customer_ito', 'customer@gmail.com', NULL, '$2y$12$ot7YBTwacI67gjzlnErQVuu0PDUG8uBAzLIjcXRHJAJUtzdAev1hu', 'customer', NULL, '2025-08-30 17:32:24', '2025-08-30 17:32:24', NULL);

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
-- Indexes for table `cemeteries`
--
ALTER TABLE `cemeteries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation_user`
--
ALTER TABLE `conversation_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_user_conversation_id_foreign` (`conversation_id`),
  ADD KEY `conversation_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_users_conversation_id_foreign` (`conversation_id`),
  ADD KEY `conversation_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `deceased`
--
ALTER TABLE `deceased`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deceased_lot_id_foreign` (`lot_id`);

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
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_conversation_id_foreign` (`conversation_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `message_statuses`
--
ALTER TABLE `message_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_statuses_message_id_foreign` (`message_id`),
  ADD KEY `message_statuses_user_id_foreign` (`user_id`);

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
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_lot_id_foreign` (`lot_id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_approved_id_foreign` (`approved_id`);

--
-- Indexes for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_payments_lot_id_foreign` (`lot_id`),
  ADD KEY `reservation_payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `terms_and_agreements`
--
ALTER TABLE `terms_and_agreements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_mobile_number_unique` (`mobile_number`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cemeteries`
--
ALTER TABLE `cemeteries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversation_user`
--
ALTER TABLE `conversation_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversation_users`
--
ALTER TABLE `conversation_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deceased`
--
ALTER TABLE `deceased`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_statuses`
--
ALTER TABLE `message_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_and_agreements`
--
ALTER TABLE `terms_and_agreements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversation_user`
--
ALTER TABLE `conversation_user`
  ADD CONSTRAINT `conversation_user_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD CONSTRAINT `conversation_users_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deceased`
--
ALTER TABLE `deceased`
  ADD CONSTRAINT `deceased_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_statuses`
--
ALTER TABLE `message_statuses`
  ADD CONSTRAINT `message_statuses_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_statuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_approved_id_foreign` FOREIGN KEY (`approved_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD CONSTRAINT `reservation_payments_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
