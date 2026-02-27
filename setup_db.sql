CREATE DATABASE IF NOT EXISTS `sistem_peminjaman_alat`;
USE `sistem_peminjaman_alat`;

-- Jika database sudah ada, drop tabel lama
DROP TABLE IF EXISTS `returns`;
DROP TABLE IF EXISTS `borrowings`;
DROP TABLE IF EXISTS `tools`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `failed_jobs`;
