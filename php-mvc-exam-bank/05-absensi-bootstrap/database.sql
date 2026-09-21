CREATE DATABASE IF NOT EXISTS db_absensi;
USE db_absensi;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE kelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(50) NOT NULL
);

CREATE TABLE siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kelas_id INT NOT NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id)
);

CREATE TABLE absensi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT NOT NULL,
  tanggal DATE NOT NULL,
  status ENUM('hadir', 'izin', 'sakit', 'alpa') NOT NULL,
  jam_masuk TIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (siswa_id) REFERENCES siswa(id),
  -- absensi ganda pada tanggal yang sama dicegah lewat unique key
  UNIQUE KEY unik_absensi (siswa_id, tanggal)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Absensi', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO kelas (nama) VALUES
('X RPL 1'),
('X RPL 2'),
('XI TKJ 1');

INSERT INTO siswa (nama, kelas_id) VALUES
('Ahmad Fauzi', 1),
('Bunga Citra', 1),
('Candra Wijaya', 1),
('Dinda Ayu', 2),
('Eko Prasetyo', 2);

-- contoh absensi tanggal 2026-06-22
INSERT INTO absensi (siswa_id, tanggal, status, jam_masuk, created_at) VALUES
(1, '2026-06-22', 'hadir', '07:05:00', '2026-06-22 07:05:00'),
(2, '2026-06-22', 'hadir', '07:10:00', '2026-06-22 07:10:00'),
(3, '2026-06-22', 'sakit', NULL, '2026-06-22 07:15:00'),
(4, '2026-06-22', 'izin', NULL, '2026-06-22 07:20:00'),
(5, '2026-06-22', 'alpa', NULL, '2026-06-22 16:00:00');
