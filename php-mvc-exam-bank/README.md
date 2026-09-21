# PHP MVC Exam Bank

Kumpulan 8 aplikasi web PHP native (tanpa framework) dengan arsitektur MVC, siap dipakai sebagai bahan ujian/praktikum. Setiap folder adalah aplikasi mandiri dengan database, ERD, dan fitur CRUD lengkap.

## Daftar Aplikasi

| # | Folder | Tema | UI | Tabel Utama |
|---|--------|------|----|-------------|
| 1 | `01-kasir-bootstrap` | Kasir / Point of Sale | Bootstrap 5 | users, produk, transaksi, transaksi_detail |
| 2 | `02-laundry-css` | Laundry | Custom CSS | users, pelanggan, layanan, transaksi |
| 3 | `03-rental-bootstrap` | Rental Kendaraan | Bootstrap 5 | users, kendaraan, pelanggan, transaksi |
| 4 | `04-perpustakaan-css` | Perpustakaan | Custom CSS | users, buku, anggota, peminjaman |
| 5 | `05-absensi-bootstrap` | Absensi Siswa | Bootstrap 5 | users, kelas, siswa, absensi |
| 6 | `06-inventaris-css` | Inventaris Barang | Custom CSS | users, kategori, barang, riwayat_stok |
| 7 | `07-booking-lapangan-bootstrap` | Booking Lapangan | Bootstrap 5 | users, lapangan, jadwal, booking |
| 8 | `08-pengaduan-fasilitas-css` | Pengaduan Fasilitas | Custom CSS | users, kategori, pengaduan |

## Fitur Bersama

- **Login & Sign Up** dengan password hash (`password_hash` bcrypt) dan session
- **CRUD lengkap** untuk setiap entitas (tambah, lihat, edit, hapus)
- **Relasi antar tabel** dengan foreign key (lihat `ERD.png` di setiap folder)
- **Arsitektur MVC**: `controllers/`, `models/`, `views/`, `config/`
- **Front controller**: semua request lewat `public/index.php` dengan router sederhana (`?page=...&action=...`)
- **PDO + prepared statements** (aman dari SQL injection)
- **Output escaping** dengan `htmlspecialchars` di semua view

## Cara Menjalankan

1. Import `database.sql` dari folder aplikasi ke MySQL/MariaDB:
   ```bash
   mysql -u root -p < database.sql
   ```
2. Sesuaikan kredensial database di `config/Database.php` jika perlu.
3. Jalankan server PHP dari folder aplikasi:
   ```bash
   php -S localhost:8000 -t public
   ```
4. Buka `http://localhost:8000` dan login.

### Akun Demo (semua aplikasi)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@demo.test | admin123 |

## Struktur Folder (per aplikasi)

```
├── config/Database.php    # koneksi PDO (singleton)
├── controllers/           # controller per entitas + AuthController
├── models/                # model per entitas + User
├── views/                 # view per entitas + auth/ + partials/
├── public/index.php       # front controller + router
├── assets/                # css/js (untuk varian custom CSS)
├── database.sql           # skema + data seed
└── ERD.png                # diagram relasi tabel
```

## Catatan

- Aplikasi bernomor ganjil memakai Bootstrap 5 via CDN; nomor genap memakai custom CSS murni (tanpa framework) sebagai latihan styling.
- Seed data disertakan agar aplikasi langsung bisa dicoba setelah import.
