CREATE DATABASE IF NOT EXISTS db_booking;
USE db_booking;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lapangan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis VARCHAR(50)
);

CREATE TABLE jadwal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lapangan_id INT NOT NULL,
  jam_mulai TIME NOT NULL,
  jam_selesai TIME NOT NULL,
  harga_per_jam INT NOT NULL,
  FOREIGN KEY (lapangan_id) REFERENCES lapangan(id)
);

CREATE TABLE booking (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lapangan_id INT NOT NULL,
  jadwal_id INT NOT NULL,
  tanggal DATE NOT NULL,
  jam_mulai TIME NOT NULL,
  jam_selesai TIME NOT NULL,
  durasi DECIMAL(4,1) NOT NULL,
  total INT NOT NULL,
  status ENUM('aktif', 'selesai', 'batal') NOT NULL DEFAULT 'aktif',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (lapangan_id) REFERENCES lapangan(id),
  FOREIGN KEY (jadwal_id) REFERENCES jadwal(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password) VALUES
('Admin Booking', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e');

INSERT INTO lapangan (nama, jenis) VALUES
('Lapangan Futsal A', 'futsal'),
('Lapangan Futsal B', 'futsal'),
('Lapangan Basket', 'basket');

INSERT INTO jadwal (lapangan_id, jam_mulai, jam_selesai, harga_per_jam) VALUES
(1, '08:00', '22:00', 100000),
(2, '08:00', '22:00', 100000),
(3, '08:00', '21:00', 80000);

-- contoh 1: booking 2 jam x 100000 = 200000
-- contoh 2: booking 1.5 jam x 80000 = 120000
INSERT INTO booking (lapangan_id, jadwal_id, tanggal, jam_mulai, jam_selesai, durasi, total, status, created_at) VALUES
(1, 1, '2026-06-26', '19:00', '21:00', 2.0, 200000, 'aktif', '2026-06-20 10:00:00'),
(3, 3, '2026-06-26', '16:00', '17:30', 1.5, 120000, 'aktif', '2026-06-21 14:30:00'),
(1, 1, '2026-06-27', '08:00', '10:00', 2.0, 200000, 'batal', '2026-06-22 09:00:00');
