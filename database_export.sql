-- Employee Leave Management System Database Export
-- Exported on: 2026-08-18 14:35:45
-- Database: lms_sweta_practical

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` enum('sick','personal','vacation','other') NOT NULL DEFAULT 'personal',
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaves_user_id_foreign` (`user_id`),
  KEY `leaves_approved_by_foreign` (`approved_by`),
  CONSTRAINT `leaves_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `leaves` (`id`, `user_id`, `start_date`, `end_date`, `type`, `reason`, `status`, `approved_by`, `remarks`, `created_at`, `updated_at`) VALUES
('1', '2', '2026-08-23', '2026-08-25', 'personal', 'Family gathering and personal matters', 'approved', '1', NULL, '2026-08-18 11:47:54', '2026-08-18 11:47:54'),
('2', '2', '2026-09-02', '2026-09-04', 'sick', 'Medical checkup and recovery', 'pending', NULL, NULL, '2026-08-18 11:47:54', '2026-08-18 11:47:54'),
('3', '3', '2026-08-28', '2026-09-01', 'vacation', 'Vacation with family to hill station', 'approved', '1', NULL, '2026-08-18 11:47:54', '2026-08-18 11:47:54'),
('4', '3', '2026-09-07', '2026-09-09', 'personal', 'Personal emergency', 'rejected', '1', 'Insufficient notice period. Please reapply with more advance notice.', '2026-08-18 11:47:54', '2026-08-18 11:47:54'),
('5', '4', '2026-08-26', '2026-08-27', 'sick', 'Flu and rest required', 'pending', NULL, NULL, '2026-08-18 11:47:54', '2026-08-18 11:47:54'),
('6', '2', '2026-08-19', '2026-08-19', 'sick', 'Sick Leave Approval', 'approved', '1', NULL, '2026-08-18 12:21:12', '2026-08-18 12:23:24'),
('7', '3', '2026-08-19', '2026-08-19', 'sick', 'Sick Leave Approval', 'approved', '1', NULL, '2026-08-18 12:22:15', '2026-08-18 12:23:11');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
('1', '0001_01_01_000000_create_users_table', '1'),
('2', '0001_01_01_000001_create_cache_table', '1'),
('3', '0001_01_01_000002_create_jobs_table', '1'),
('4', '2026_08_18_114102_create_leaves_table', '1'),
('5', '2026_08_18_114120_add_role_to_users_table', '1');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TWsHgt2V8yOJr5YefvG2xHT2404ax7358xyytpCq', '2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzNvRTRSWDUxRnFlbkRSNkpOZjJtb1ljekdIdjB0STVnWXlaZG85NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZWF2ZXMiO3M6NToicm91dGUiO3M6MTI6ImxlYXZlcy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', '1787056162');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('employee','admin') NOT NULL DEFAULT 'employee',
  `department` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `role`, `department`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('1', 'Admin User', 'admin@lms.com', 'admin', 'Administration', NULL, '$2y$12$A49tz0jl67G8qKlo9JKYm.bu70rLFDv2w0pVTdMO.qjIEhpRGbRTS', NULL, '2026-08-18 11:47:51', '2026-08-18 11:47:51'),
('2', 'John Doe', 'john@lms.com', 'employee', 'IT', NULL, '$2y$12$eNUITCfmW5fyKCnESGa1veZsYsaG/0HiinMybYE7PRcDagDQq5Yx6', NULL, '2026-08-18 11:47:52', '2026-08-18 11:47:52'),
('3', 'Jane Smith', 'jane@lms.com', 'employee', 'HR', NULL, '$2y$12$x2zQxcKeD8mRBZxtodEcoO/F.ggTx5FnWeVnat.Z7eZCd.EiD5vk.', NULL, '2026-08-18 11:47:53', '2026-08-18 11:47:53'),
('4', 'Mike Johnson', 'mike@lms.com', 'employee', 'Finance', NULL, '$2y$12$muIFJEVdQfqUBj/.fOXwCeXCU2KiBnwAZz5wNx2SeHic5AQiIN1.a', NULL, '2026-08-18 11:47:54', '2026-08-18 11:47:54');

SET FOREIGN_KEY_CHECKS=1;
