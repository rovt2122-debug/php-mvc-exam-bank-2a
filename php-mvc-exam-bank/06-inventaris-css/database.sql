CREATE DATABASE IF NOT EXISTS db_inventaris;
USE db_inventaris;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kategori_id INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  lokasi VARCHAR(100),
  FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

CREATE TABLE riwayat_stok (
  id INT AUTO_INCREMENT PRIMARY KEY,
  barang_id INT NOT NULL,
  jenis ENUM('masuk', 'keluar') NOT NULL,
  jumlah INT NOT NULL,
  keterangan VARCHAR(255),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (barang_id) REFERENCES barang(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Inventaris', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO kategori (nama) VALUES
('Elektronik'),
('Mebeler'),
('Alat Tulis');

INSERT INTO barang (nama, kategori_id, stok, lokasi) VALUES
('Laptop Lenovo', 1, 3, 'Lab Komputer'),
('Proyektor Epson', 1, 2, 'Ruang Kelas'),
('Kursi Plastik', 2, 50, 'Gudang'),
('Spidol Whiteboard', 3, 20, 'Ruang Guru');

-- contoh riwayat: barang masuk dan keluar dengan timestamp
INSERT INTO riwayat_stok (barang_id, jenis, jumlah, keterangan, created_at) VALUES
(4, 'masuk', 30, 'pembelian awal tahun ajaran', '2026-06-15 08:00:00'),
(4, 'keluar', 10, 'dipakai ruang kelas', '2026-06-20 10:30:00'),
(1, 'keluar', 1, 'dipinjam untuk lomba', '2026-06-21 13:00:00');
