CREATE DATABASE IF NOT EXISTS db_laundry;
USE db_laundry;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telepon VARCHAR(20),
  alamat VARCHAR(255)
);

CREATE TABLE layanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  harga_per_kg INT NOT NULL,
  biaya_tambahan INT NOT NULL DEFAULT 0
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pelanggan_id INT NOT NULL,
  layanan_id INT NOT NULL,
  berat DECIMAL(5,2) NOT NULL,
  harga_per_kg INT NOT NULL,
  biaya_tambahan INT NOT NULL DEFAULT 0,
  total INT NOT NULL,
  status ENUM('diproses', 'dicuci', 'selesai', 'diambil') NOT NULL DEFAULT 'diproses',
  tanggal_masuk DATE NOT NULL,
  tanggal_selesai DATE NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id),
  FOREIGN KEY (layanan_id) REFERENCES layanan(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Laundry', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO pelanggan (nama, telepon, alamat) VALUES
('Budi Santoso', '081234567890', 'Jl. Melati No. 5'),
('Siti Aminah', '089876543210', 'Jl. Kenanga No. 12'),
('Rudi Hartono', '081122334455', 'Jl. Mawar No. 8');

INSERT INTO layanan (nama, harga_per_kg, biaya_tambahan) VALUES
('Reguler', 6000, 0),
('Express', 6000, 10000);

-- contoh: 5 kg reguler = 5 x 6000 = 30000
-- contoh: 4 kg express = (4 x 6000) + 10000 = 34000
INSERT INTO transaksi (pelanggan_id, layanan_id, berat, harga_per_kg, biaya_tambahan, total, status, tanggal_masuk, tanggal_selesai, created_at) VALUES
(1, 1, 5.00, 6000, 0, 30000, 'selesai', '2026-06-18', '2026-06-19', '2026-06-18 09:30:00'),
(2, 2, 4.00, 6000, 10000, 34000, 'dicuci', '2026-06-20', NULL, '2026-06-20 13:00:00'),
(3, 1, 3.50, 6000, 0, 21000, 'diproses', '2026-06-21', NULL, '2026-06-21 08:45:00');
