CREATE DATABASE IF NOT EXISTS db_perpustakaan;
USE db_perpustakaan;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  pengarang VARCHAR(100),
  tahun YEAR,
  stok INT NOT NULL DEFAULT 0
);

CREATE TABLE anggota (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  nomor_anggota VARCHAR(20),
  telepon VARCHAR(20)
);

CREATE TABLE peminjaman (
  id INT AUTO_INCREMENT PRIMARY KEY,
  buku_id INT NOT NULL,
  anggota_id INT NOT NULL,
  tanggal_pinjam DATE NOT NULL,
  tanggal_kembali DATE NOT NULL,
  tanggal_dikembalikan DATE NULL,
  denda INT NOT NULL DEFAULT 0,
  status ENUM('dipinjam', 'kembali') NOT NULL DEFAULT 'dipinjam',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (buku_id) REFERENCES buku(id),
  FOREIGN KEY (anggota_id) REFERENCES anggota(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Perpus', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO buku (judul, pengarang, tahun, stok) VALUES
('Laskar Pelangi', 'Andrea Hirata', 2005, 4),
('Bumi Manusia', 'Pramoedya A. Toer', 1980, 3),
('Negeri 5 Menara', 'A. Fuadi', 2009, 0),
('Atomic Habits', 'James Clear', 2018, 5);

INSERT INTO anggota (nama, nomor_anggota, telepon) VALUES
('Rina Marlina', 'A001', '081234567890'),
('Fajar Nugroho', 'A002', '089876543210');

-- contoh 1: masih dipinjam, jatuh tempo 7 hari setelah pinjam
-- contoh 2: dikembalikan terlambat 4 hari, denda = 4 x 1000 = 4000
INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pinjam, tanggal_kembali, tanggal_dikembalikan, denda, status, created_at) VALUES
(1, 1, '2026-06-18', '2026-06-25', NULL, 0, 'dipinjam', '2026-06-18 10:00:00'),
(2, 2, '2026-06-08', '2026-06-15', '2026-06-19', 4000, 'kembali', '2026-06-08 09:00:00');
