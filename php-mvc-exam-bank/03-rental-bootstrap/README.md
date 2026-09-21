# 03 — Rental Kendaraan (Bootstrap 5)

Aplikasi rental kendaraan: kelola armada dan pelanggan, catat penyewaan harian, dan kembalikan unit.

## Fitur

- CRUD kendaraan (plat, merk, tipe, harga per hari, status)
- CRUD pelanggan
- Transaksi sewa: pilih kendaraan + pelanggan, tentukan tanggal mulai/selesai, total dihitung otomatis
- Status sewa: aktif / selesai — kendaraan otomatis tidak bisa disewa saat masih aktif
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    users ||--o{ transaksi : mencatat
    kendaraan ||--o{ transaksi : disewa
    pelanggan ||--o{ transaksi : menyewa

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    kendaraan {
        int id PK
        varchar plat UK
        varchar merk
        varchar tipe
        decimal harga_per_hari
        enum status
    }
    pelanggan {
        int id PK
        varchar nama
        varchar telepon
        varchar alamat
    }
    transaksi {
        int id PK
        int user_id FK
        int kendaraan_id FK
        int pelanggan_id FK
        date tanggal_mulai
        date tanggal_selesai
        decimal total
        enum status
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
