CREATE DATABASE IF NOT EXISTS db_pengaduan;
USE db_pengaduan;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL
);

CREATE TABLE pengaduan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  kategori_id INT NOT NULL,
  judul VARCHAR(150) NOT NULL,
  deskripsi TEXT,
  lokasi VARCHAR(150),
  status ENUM('diajukan', 'diproses', 'selesai') NOT NULL DEFAULT 'diajukan',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

-- akun demo, passwordnya admin123
INSERT INTO users (nama, email, password, role) VALUES
('Admin Sekolah', 'admin@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e', 'admin'),
('Budi Siswa', 'budi@demo.com', '$2y$10$bJGMKecAaOl2L6vqQc7InOZnIC3m45V6EnqY6touMejHCS0nH4g2e', 'user');

INSERT INTO kategori (nama) VALUES
('Ruang Kelas'),
('Toilet'),
('Laboratorium'),
('Lapangan');

-- contoh pengaduan dengan status berbeda
INSERT INTO pengaduan (user_id, kategori_id, judul, deskripsi, lokasi, status, created_at) VALUES
(2, 2, 'Kran toilet bocor', 'Kran wudhu toilet lantai 1 bocor, air terus mengalir', 'Toilet lantai 1', 'diajukan', '2026-06-20 08:30:00'),
(2, 1, 'Kaca jendela pecah', 'Kaca jendela kelas pecah kena bola', 'Kelas XI RPL 1', 'diproses', '2026-06-18 10:00:00'),
(1, 3, 'Komputer lab tidak menyala', '5 komputer di lab tidak bisa menyala', 'Lab Komputer 2', 'selesai', '2026-06-15 13:20:00');
