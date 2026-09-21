CREATE DATABASE IF NOT EXISTS db_kasir;
USE db_kasir;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  harga INT NOT NULL
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total INT NOT NULL,
  bayar INT NOT NULL,
  kembalian INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE transaksi_detail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transaksi_id INT NOT NULL,
  produk_id INT NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  diskon INT NOT NULL DEFAULT 0,
  subtotal INT NOT NULL,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
  FOREIGN KEY (produk_id) REFERENCES produk(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Kasir', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO produk (nama, harga) VALUES
('Indomie Goreng', 3500),
('Teh Kotak', 5000),
('Roti Sobek', 2000),
('Air Mineral 600ml', 4000),
('Kopi Sachet', 1500);

-- contoh transaksi 1: 10 roti, kena diskon (8 x 2000 + 2 x 1000 = 18000)
INSERT INTO transaksi (user_id, total, bayar, kembalian, created_at) VALUES
(1, 18000, 20000, 2000, '2026-06-20 10:15:00'),
(1, 10000, 50000, 40000, '2026-06-20 11:02:00');

INSERT INTO transaksi_detail (transaksi_id, produk_id, harga, qty, diskon, subtotal) VALUES
(1, 3, 2000, 10, 2000, 18000),
(2, 1, 3500, 1, 0, 3500),
(2, 2, 5000, 1, 0, 5000),
(2, 5, 1500, 1, 0, 1500);
