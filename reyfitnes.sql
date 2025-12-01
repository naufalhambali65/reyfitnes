-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table reygym_app.attendances: ~0 rows (approximately)

-- Dumping data for table reygym_app.banks: ~1 rows (approximately)
INSERT INTO `banks` (`id`, `slug`, `name`, `account_number`, `account_holder_name`, `status`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 'bank-central-asia-bca', 'Bank Central Asia (BCA)', '1234-5678-9012-3456', 'REY FITNES', 'active', '<div>Bank Utama&nbsp;</div>', '2025-11-30 18:30:16', '2025-11-30 18:30:16', 2, NULL);

-- Dumping data for table reygym_app.cache: ~0 rows (approximately)

-- Dumping data for table reygym_app.cache_locks: ~0 rows (approximately)

-- Dumping data for table reygym_app.class_bookings: ~0 rows (approximately)

-- Dumping data for table reygym_app.class_categories: ~0 rows (approximately)

-- Dumping data for table reygym_app.failed_jobs: ~0 rows (approximately)

-- Dumping data for table reygym_app.gym_classes: ~0 rows (approximately)

-- Dumping data for table reygym_app.jobs: ~0 rows (approximately)

-- Dumping data for table reygym_app.job_batches: ~0 rows (approximately)

-- Dumping data for table reygym_app.members: ~0 rows (approximately)

-- Dumping data for table reygym_app.memberships: ~2 rows (approximately)
INSERT INTO `memberships` (`id`, `slug`, `name`, `price`, `status`, `description`, `duration_days`, `features`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 'paket-membership-standar-30-hari', 'Paket Membership Standar (30 Hari)', 150000.00, 'available', '<div>Nikmati pengalaman latihan yang lengkap dengan Paket Membership Standar kami. Didesain untuk Anda yang ingin memulai perjalanan fitness dengan fasilitas terbaik tanpa batasan alat. Dalam 30 hari penuh, Anda mendapatkan akses optimal ke seluruh area gym untuk mendukung pencapaian target tubuh ideal Anda.<br>Baik Anda pemula maupun sudah berpengalaman, paket ini memberikan kebebasan untuk berlatih kapan saja selama jam operasional dengan peralatan yang lengkap, aman, dan modern.&nbsp;</div>', 30, '<ul><li><strong>Akses Penuh ke Gym Selama Jam Operasional</strong></li><li><strong>Akses Semua Alat &amp; Fasilitas</strong></li><li><strong>Area Latihan yang Bersih &amp; Nyaman</strong></li><li><strong>Pendampingan Staff (Light Assistance)</strong></li><li><strong>Suasana Gym yang Enerjik</strong></li><li><strong>Keamanan Area Gym Terjamin</strong></li></ul><div><br></div>', '2025-11-30 18:34:32', '2025-11-30 18:34:32', 2, NULL),
	(2, 'paket-membership-private-30-hari', 'Paket Membership Private (30 Hari)', 1000000.00, 'available', '<div><strong>Level premium untuk Anda yang ingin hasil lebih maksimal tanpa repot.</strong><br> Dengan Paket Membership Private, Anda tidak hanya mendapatkan akses penuh ke seluruh fasilitas gym — tetapi juga pendampingan langsung oleh <strong>Personal Trainer</strong> profesional selama 30 hari.<br> Semua fitur Membership Standar sudah <strong>termasuk</strong>, dan Anda <strong>tidak perlu membayar biaya membership standar senilai 150K</strong>. Hanya bayar paket Private, dan langsung menikmati layanan lengkap + trainer pribadi.&nbsp;</div>', 30, '<ul><li><strong>Didampingi Personal Trainer Profesional</strong></li><li><strong>Akses Penuh ke Gym Selama Jam Operasional</strong></li><li><strong>Akses Semua Alat &amp; Fasilitas Tanpa Batas</strong></li><li><strong>Rencana Latihan (Personalized Training Plan)</strong></li><li><strong>Pemantauan Progress Setiap Minggu</strong></li><li><strong>Lingkungan Latihan Bersih &amp; Nyaman</strong></li><li><strong>Keamanan Area Gym Terjamin</strong></li></ul>', '2025-11-30 18:38:34', '2025-11-30 18:38:34', 2, NULL);

-- Dumping data for table reygym_app.member_memberships: ~0 rows (approximately)

-- Dumping data for table reygym_app.messages: ~0 rows (approximately)
INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `is_read`, `message`, `created_at`, `updated_at`) VALUES
	(1, 'Testing', 'testing@gmail.com', 'TESTING', 0, 'testing', '2025-11-30 19:38:38', '2025-11-30 19:38:38');

-- Dumping data for table reygym_app.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_16_073918_create_memberships_table', 1),
	(5, '2025_11_17_024156_create_trainers_table', 1),
	(6, '2025_11_17_024219_create_messages_table', 1),
	(7, '2025_11_17_024310_create_class_categories_table', 1),
	(8, '2025_11_17_024312_create_gym_classes_table', 1),
	(9, '2025_11_17_024347_create_members_table', 1),
	(10, '2025_11_17_024357_create_class_bookings_table', 1),
	(11, '2025_11_20_073600_create_banks_table', 1),
	(12, '2025_11_20_073624_create_product_units_table', 1),
	(13, '2025_11_20_073640_create_product_categories_table', 1),
	(14, '2025_11_20_073724_create_products_table', 1),
	(15, '2025_11_20_073838_create_payments_table', 1),
	(16, '2025_11_20_073852_create_stock_logs_table', 1),
	(17, '2025_11_20_074004_create_payment_items_table', 1),
	(18, '2025_11_20_074837_create_member_memberships_table', 1),
	(19, '2025_11_20_080137_create_notifications_table', 1),
	(20, '2025_11_24_052703_add_extra_columns_to_payments_table', 1),
	(21, '2025_11_24_070233_make_bank_id_nullable_in_payments_table', 1),
	(22, '2025_11_24_145035_update_status_enum_on_member_memberships_table', 1),
	(23, '2025_11_25_013333_create_attendances_table', 1),
	(24, '2025_11_26_164501_update_gym_classes_table', 1),
	(25, '2025_11_27_102635_add_day_to_class_bookings_table', 1),
	(26, '2025_11_28_011307_add_slug_to_product_table', 1),
	(27, '2025_11_28_011603_alter_products_name_remove_unique', 1);

-- Dumping data for table reygym_app.notifications: ~0 rows (approximately)

-- Dumping data for table reygym_app.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table reygym_app.payments: ~0 rows (approximately)

-- Dumping data for table reygym_app.payment_items: ~0 rows (approximately)

-- Dumping data for table reygym_app.products: ~2 rows (approximately)
INSERT INTO `products` (`id`, `category_id`, `unit_id`, `name`, `slug`, `price`, `cost`, `stock`, `min_stock`, `description`, `image`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 3, 1, 'Le Minerale 600ml', 'le-minerale-600ml', 5000.00, 0.00, 0, 5, NULL, 'product-image/BdJ6ToR3F8LupQp5gcHkWSHCkPYVog5KvljIV8uX.jpg', 'unavailable', '2025-11-30 18:55:05', '2025-11-30 18:55:05', 2, NULL),
	(2, 3, 1, 'Susu Mass', 'susu-mass', 15000.00, 0.00, 0, 5, NULL, NULL, 'unavailable', '2025-11-30 18:56:40', '2025-11-30 20:16:05', 2, 2),
	(3, 1, 2, 'Akses Masuk ReyFitnes (1 Kali)', 'akses-masuk-reyfitnes-1-kali', 20000.00, 0.00, 99999999, 0, '<div>Akses masuk untuk 1 kali masuk ke Rey Fitnes</div>', 'product-image/H9MV0vnyDYmGDzKleu4FbRnGXd1l6Miw8ud3Ues7.png', 'available', '2025-11-30 20:22:46', '2025-11-30 20:22:46', 2, NULL);

-- Dumping data for table reygym_app.product_categories: ~4 rows (approximately)
INSERT INTO `product_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 'Akses Masuk', 'akses-masuk', '2025-11-30 18:46:36', '2025-11-30 18:46:36', 2, NULL),
	(2, 'Makanan', 'makanan', '2025-11-30 18:48:25', '2025-11-30 18:48:25', 2, NULL),
	(3, 'Minuman', 'minuman', '2025-11-30 18:49:34', '2025-11-30 18:49:34', 2, NULL),
	(4, 'Suplemen Fitness', 'suplemen-fitness', '2025-11-30 18:49:44', '2025-11-30 18:49:44', 2, NULL);

-- Dumping data for table reygym_app.product_units: ~3 rows (approximately)
INSERT INTO `product_units` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 'Pcs', '2025-11-30 18:46:51', '2025-11-30 18:46:51', 2, NULL),
	(2, 'Unit', '2025-11-30 18:47:00', '2025-11-30 18:47:00', 2, NULL),
	(3, 'Porsi', '2025-11-30 18:47:19', '2025-11-30 18:47:19', 2, NULL);

-- Dumping data for table reygym_app.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('pgFs18v9VIQxdSu4grsIGEqrZ1kuloCjuGu0brSw', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOVBQdFpNdXpJc1FIWFo0dHhMYmh0eU5Sem8xcDBoZmdkamppZDY4MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1764534211);

-- Dumping data for table reygym_app.stock_logs: ~3 rows (approximately)
INSERT INTO `stock_logs` (`id`, `product_id`, `quantity`, `type`, `note`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 3, 99999999, 'in', NULL, '2025-11-30 20:22:46', '2025-11-30 20:22:46', 2, NULL);

-- Dumping data for table reygym_app.trainers: ~1 rows (approximately)
INSERT INTO `trainers` (`id`, `user_id`, `specialty`, `years_experience`, `bio`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
	(1, 3, 'All-Round Personal Trainer', 10, '<div>Trainer profesional dengan keahlian lengkap di bidang kebugaran, mulai dari pembentukan otot, penurunan berat badan, peningkatan stamina, koreksi postur, hingga panduan nutrisi dasar. Berpengalaman melatih berbagai tingkat kemampuan — dari pemula hingga atlet — dengan metode yang aman, efektif, dan terarah. Siap membantu Anda mencapai hasil terbaik dalam waktu optimal.&nbsp;</div>', 'active', '2025-11-30 18:41:58', '2025-11-30 18:41:58', 2, NULL);

-- Dumping data for table reygym_app.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `gender`, `password`, `phone`, `image`, `address`, `birth_date`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'REY FITNES ADMIN', 'reyfitnes.cs@gmail.com', NULL, '$2y$12$y3blj9sGE5YBnE02gJN9ne/hHZuIssT9FB3l9XoYkFsMDxUjW/mC.', NULL, NULL, NULL, NULL, 'admin', '2025-11-30 18:24:14', 'VQeYYhuadN', '2025-11-30 18:24:14', '2025-11-30 18:24:14'),
	(2, 'naufal', 'naufalhambali65@gmail.com', NULL, '$2y$12$tCuoJWL5XULEVmz8cUFAY.gvInZEJH1vmo7975wl8Y61kOI1sTYfe', NULL, NULL, NULL, NULL, 'super_admin', '2025-11-30 18:24:14', 'uiVwGfjG2j', '2025-11-30 18:24:14', '2025-11-30 18:24:14'),
	(3, 'Rey', 'reyfitnes.trainer@gmail.com', 'male', '$2y$12$.KPxzZLkVu1mUG0QtGyZBuCxmWmkynrpj9uZIswMCjTCxT5R1Zt/.', '08123123123123', 'user-profile-image/qADp5yhnVgcay9WmrWwucxD47Kcz4rGBJQRYJP2b.jpg', 'Komplek Bundaran, palupi permai, Jl. I Gusti Ngurah Rai No.5, RW.6, Pengawu, Kec. Tatanga, Kota Palu, Sulawesi Tengah 94222', '1980-02-01', 'trainer', NULL, NULL, '2025-11-30 18:41:58', '2025-11-30 18:41:58');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
