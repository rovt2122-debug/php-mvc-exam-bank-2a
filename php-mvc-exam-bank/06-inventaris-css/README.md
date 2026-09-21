# 06 — Inventaris Barang (Custom CSS)

Aplikasi inventaris gudang: kelola kategori dan barang, catat barang masuk/keluar, dan pantau stok minimum.

## Fitur

- CRUD kategori
- CRUD barang (kode, nama, kategori, stok, stok minimal, harga)
- Stok masuk/keluar: setiap perubahan tercatat di riwayat stok
- Peringatan stok di bawah minimum
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    kategori ||--o{ barang : berisi
    users ||--o{ riwayat_stok : mencatat
    barang ||--o{ riwayat_stok : tercatat

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    kategori {
        int id PK
        varchar nama
    }
    barang {
        int id PK
        int kategori_id FK
        varchar kode UK
        varchar nama
        int stok
        int stok_minimal
        decimal harga
    }
    riwayat_stok {
        int id PK
        int user_id FK
        int barang_id FK
        enum tipe
        int jumlah
        varchar keterangan
        timestamp created_at
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
