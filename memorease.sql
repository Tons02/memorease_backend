-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2025 at 02:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.15

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
(1, NULL, 'Providence Memorial park', 'Sample description', 'Dasma', '[14.288794, 120.970325]', '2025-06-25 17:29:00', '2025-06-25 17:29:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deceased`
--

CREATE TABLE `deceased` (
  `id` bigint UNSIGNED NOT NULL,
  `lot_id` bigint UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `death_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `burial_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `death_certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinates` json NOT NULL,
  `status` enum('available','reserved','occupied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `reserved_until` datetime DEFAULT NULL,
  `price` decimal(7,2) NOT NULL,
  `promo_price` decimal(7,2) DEFAULT NULL,
  `promo_until` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `lot_number`, `coordinates`, `status`, `reserved_until`, `price`, `promo_price`, `promo_until`, `is_featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lot A - 1', '[[14.287216693761913, 120.9713226556778], [14.287242672114129, 120.9715211391449], [14.28713356301464, 120.971537232399], [14.287112780323016, 120.97133338451388]]', 'available', NULL, 123.00, NULL, NULL, 0, '2025-06-30 17:29:44', '2025-06-30 17:42:21', '2025-06-30 17:42:21'),
(2, '123', '[[14.28724268626518, 120.971537232399], [14.287268664614407, 120.97168743610384], [14.28719592522901, 120.971719622612], [14.287159555527516, 120.97154796123506]]', 'available', NULL, 123.00, NULL, NULL, 0, '2025-06-30 17:46:14', '2025-06-30 17:46:14', NULL),
(3, '23', '[[14.287138772838295, 120.97155869007112], [14.287159555527516, 120.97172498703004], [14.28707642475914, 120.971719622612], [14.287071229085097, 120.9715747833252]]', 'available', NULL, 23422.00, 23.00, '2025-07-11', 1, '2025-06-30 17:46:35', '2025-06-30 17:46:35', NULL);

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
(1, '0001_01_01_000000_create_roles_table', 1),
(2, '0001_01_01_000001_create_users_table', 1),
(3, '0001_01_01_000002_create_cache_table', 1),
(4, '0001_01_01_000003_create_jobs_table', 1),
(5, '2025_06_21_114838_create_cemeteries_table', 1),
(6, '2025_06_21_114857_create_lots_table', 1),
(7, '2025_06_21_114906_create_reservations_table', 1),
(8, '2025_06_21_114927_create_deceased_table', 1),
(9, '2025_06_21_124054_create_reservation_payments_table', 1),
(10, '2025_06_21_131219_create_personal_access_tokens_table', 1);

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
(2, 'App\\Models\\User', 1, 'admin', 'b75167e4300dcb5da4ec71ad929862053e298d8ecce9780f68047f4d72d5b6b9', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', NULL, NULL, '2025-06-26 22:08:37', '2025-06-26 22:08:37'),
(4, 'App\\Models\\User', 1, 'admin', '41583963f176c34b84db5becdedce403bfdcfaaeb5638ae8643fd91a350f19c6', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', NULL, NULL, '2025-06-29 17:50:36', '2025-06-29 17:50:36'),
(5, 'App\\Models\\User', 1, 'admin', '5e56b4c301cce513488f516511463fa7f256187fa9ad5dfdc95e0fdcda241380', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', NULL, NULL, '2025-06-29 18:15:53', '2025-06-29 18:15:53'),
(6, 'App\\Models\\User', 1, 'admin', 'a8cec7ff3922ca4aacb333ad16741081f07b8eee3c18e64109800fd441b40f01', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', NULL, NULL, '2025-06-29 18:19:35', '2025-06-29 18:19:35'),
(7, 'App\\Models\\User', 1, 'admin', '1770bfbc013f8cd828a803af02a0b1507b5cf8ae885add4e7014f6502528ed97', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', '2025-06-29 18:56:47', NULL, '2025-06-29 18:19:59', '2025-06-29 18:56:47'),
(8, 'App\\Models\\User', 1, 'admin', '784a58132895178b3ee02daf0e1c88423a094099281739dcbdabbffccff67fad', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', '2025-06-29 18:54:45', NULL, '2025-06-29 18:53:54', '2025-06-29 18:54:45'),
(9, 'App\\Models\\User', 1, 'admin', '0b993610ded363281e75608c7e8691cf94889a66edc891f0d9afe84b0a3d3e17', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', '2025-06-30 17:06:21', NULL, '2025-06-30 00:27:25', '2025-06-30 17:06:21'),
(11, 'App\\Models\\User', 1, 'admin', 'cefaa38d5071d9c68bc62817d3dfa84ed21f64838733b02e92bd076a8c63ee4f', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', '2025-06-30 17:30:19', NULL, '2025-06-30 17:30:01', '2025-06-30 17:30:19'),
(14, 'App\\Models\\User', 1, 'admin', 'cdf4e3db19c9027b4cb62b428e7ff9c98bd40041f32f85544ced05a4a472ed5c', '[\"role\",\"user\",\"dashboard\",\"user-management\",\"masterlist\",\"cemeteries\"]', '2025-06-30 18:36:46', NULL, '2025-06-30 18:26:53', '2025-06-30 18:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_permission` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `access_permission`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '[\"role\", \"user\", \"dashboard\", \"user-management\", \"masterlist\", \"cemeteries\"]', '2025-06-26 17:33:24', '2025-06-26 17:33:24', NULL),
(2, 'customer', '[\"dashboard\"]', '2025-06-26 17:33:38', '2025-06-26 17:33:38', NULL),
(3, 'Testing', '[\"dashboard\"]', '2025-06-30 17:37:43', '2025-06-30 17:37:43', NULL);

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
  `role_id` bigint UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `profile_picture`, `fname`, `mi`, `lname`, `suffix`, `gender`, `mobile_number`, `birthday`, `address`, `username`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default_profile.jpg', 'Antonio', 'D', 'Montilla', 'Jr', 'male', '+639168620219', '06-02-2001', 'Pampanga', 'admin', 'sample@gmail.com', NULL, '$2y$12$b.BA4DqiKinLgeXmGfYLR.tmydjngneD0Yx5sX8b2HfzJAbUTt6EW', 1, NULL, '2025-06-26 17:33:55', '2025-06-30 18:31:47', NULL),
(2, 'default_profile.jpg', 'Antonio', 'D', 'Montilla', 'Jr', 'male', '+639231231231', '07-09-2025', 'Pampanga', 'tons', 'testing@gmail.com', NULL, '$2y$12$ykgfk7Fxq5TIFv6Uet/NDuurh1C.CK1oVR30HMk1QE4Vfw941PL6G', 1, NULL, '2025-06-30 17:25:21', '2025-06-30 18:30:23', NULL);

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
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Indexes for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_payments_lot_id_foreign` (`lot_id`),
  ADD KEY `reservation_payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `users_mobile_number_unique` (`mobile_number`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cemeteries`
--
ALTER TABLE `cemeteries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deceased`
--
ALTER TABLE `deceased`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deceased`
--
ALTER TABLE `deceased`
  ADD CONSTRAINT `deceased_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD CONSTRAINT `reservation_payments_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
