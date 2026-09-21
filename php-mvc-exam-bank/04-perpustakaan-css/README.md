# 04 — Perpustakaan (Custom CSS)

Aplikasi perpustakaan: kelola buku dan anggota, catat peminjaman, proses pengembalian, dan hitung denda keterlambatan otomatis.

## Fitur

- CRUD buku (judul, penulis, penerbit, tahun, stok)
- CRUD anggota
- Peminjaman: pilih buku + anggota, stok otomatis berkurang
- Pengembalian: stok kembali, denda dihitung dari keterlambatan (Rp500/hari)
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    users ||--o{ peminjaman : mencatat
    buku ||--o{ peminjaman : dipinjam
    anggota ||--o{ peminjaman : meminjam

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    buku {
        int id PK
        varchar judul
        varchar penulis
        varchar penerbit
        int tahun
        int stok
    }
    anggota {
        int id PK
        varchar nama
        varchar telepon
        varchar alamat
    }
    peminjaman {
        int id PK
        int user_id FK
        int buku_id FK
        int anggota_id FK
        date tanggal_pinjam
        date tanggal_kembali
        date tanggal_dikembalikan
        enum status
        decimal denda
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
