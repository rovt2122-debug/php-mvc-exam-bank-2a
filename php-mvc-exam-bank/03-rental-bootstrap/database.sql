CREATE DATABASE IF NOT EXISTS db_rental;
USE db_rental;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE kendaraan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  plat VARCHAR(20),
  harga_per_hari INT NOT NULL
);

CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telepon VARCHAR(20),
  alamat VARCHAR(255)
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kendaraan_id INT NOT NULL,
  pelanggan_id INT NOT NULL,
  tanggal_mulai DATETIME NOT NULL,
  tanggal_selesai DATETIME NOT NULL,
  harga_per_hari INT NOT NULL,
  jumlah_hari INT NOT NULL,
  total INT NOT NULL,
  bayar INT NOT NULL,
  kembalian INT NOT NULL DEFAULT 0,
  status ENUM('lunas', 'belum lunas') NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kendaraan_id) REFERENCES kendaraan(id),
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Rental', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO kendaraan (nama, plat, harga_per_hari) VALUES
('Honda Vario', 'B 1234 AB', 70000),
('Toyota Avanza', 'B 5678 CD', 350000),
('Honda Beat', 'D 9012 EF', 60000);

INSERT INTO pelanggan (nama, telepon, alamat) VALUES
('Andi Wijaya', '081234567890', 'Jl. Sudirman No. 10'),
('Dewi Lestari', '089876543210', 'Jl. Diponegoro No. 3');

-- contoh 1: 26/06/2026 10:00 sampai 29/06/2026 10:00 = 3 hari
-- 3 x 100000 = 300000, bayar 300000 = lunas
-- contoh 2: tanggal sama beda jam (10:00 - 16:00) = dihitung 1 hari
INSERT INTO transaksi (kendaraan_id, pelanggan_id, tanggal_mulai, tanggal_selesai, harga_per_hari, jumlah_hari, total, bayar, kembalian, status, created_at) VALUES
(2, 1, '2026-06-26 10:00:00', '2026-06-29 10:00:00', 350000, 3, 1050000, 1050000, 0, 'lunas', '2026-06-25 09:00:00'),
(1, 2, '2026-06-26 10:00:00', '2026-06-26 16:00:00', 70000, 1, 70000, 50000, 0, 'belum lunas', '2026-06-26 09:30:00');
