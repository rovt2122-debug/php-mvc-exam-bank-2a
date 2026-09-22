CREATE DATABASE IF NOT EXISTS db_parkir CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_parkir;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,nama VARCHAR(100) NOT NULL,email VARCHAR(150) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL,role ENUM('admin','user') NOT NULL DEFAULT 'user',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE parkir(id INT AUTO_INCREMENT PRIMARY KEY,plat_nomor VARCHAR(20) NOT NULL,jenis_roda ENUM('2','4') NOT NULL,waktu_masuk TIMESTAMP NOT NULL,waktu_keluar TIMESTAMP NULL,status ENUM('masuk','keluar') NOT NULL DEFAULT 'masuk',total_bayar INT NOT NULL DEFAULT 0);
INSERT INTO users(nama,email,password,role) VALUES ('Admin Parkir','admin@parkir.test','$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e','admin'),('Petugas Parkir','petugas@parkir.test','$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e','user');
