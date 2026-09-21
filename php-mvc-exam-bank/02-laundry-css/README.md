# 02 — Laundry (Custom CSS)

Aplikasi manajemen laundry: kelola pelanggan dan layanan, catat transaksi cuci berdasarkan berat (kg), dan pantau status pengerjaan.

## Fitur

- CRUD pelanggan (nama, telepon, alamat)
- CRUD layanan (nama, harga per kg, estimasi jam)
- Transaksi: pilih pelanggan + layanan, isi berat, total dihitung otomatis
- Status transaksi: proses / selesai / diambil
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    users ||--o{ transaksi : mencatat
    pelanggan ||--o{ transaksi : memiliki
    layanan ||--o{ transaksi : dipakai

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    pelanggan {
        int id PK
        varchar nama
        varchar telepon
        varchar alamat
    }
    layanan {
        int id PK
        varchar nama
        decimal harga_per_kg
        int estimasi_jam
    }
    transaksi {
        int id PK
        int user_id FK
        int pelanggan_id FK
        int layanan_id FK
        decimal berat_kg
        decimal total
        enum status
        timestamp created_at
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
