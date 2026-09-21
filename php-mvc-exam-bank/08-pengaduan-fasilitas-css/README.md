# 08 — Pengaduan Fasilitas (Custom CSS)

Aplikasi pengaduan fasilitas dengan dua peran: **user** mengajukan pengaduan, **admin** mengelola kategori dan menindaklanjuti dengan tanggapan.

## Fitur

- Login & Sign Up dengan role (`admin` / `user`)
- User: buat pengaduan (judul, kategori, lokasi, deskripsi), pantau status
- Admin: CRUD kategori, ubah status (pending / diproses / selesai / ditolak), beri tanggapan
- Riwayat pengaduan milik sendiri untuk user, semua pengaduan untuk admin

## ERD

```mermaid
erDiagram
    users ||--o{ pengaduan : mengajukan
    kategori ||--o{ pengaduan : mengelompokkan

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
        enum role
    }
    kategori {
        int id PK
        varchar nama
    }
    pengaduan {
        int id PK
        int user_id FK
        int kategori_id FK
        varchar judul
        varchar lokasi
        text deskripsi
        enum status
        text tanggapan
        timestamp created_at
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login:
- Admin: `admin@demo.test` / `admin123`
- User: `budi@demo.test` / `user123`
