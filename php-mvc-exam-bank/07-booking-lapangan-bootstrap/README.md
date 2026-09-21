# 07 — Booking Lapangan (Bootstrap 5)

Aplikasi booking lapangan olahraga: kelola lapangan dan slot jadwal, terima booking, lalu konfirmasi atau batalkan.

## Fitur

- CRUD lapangan (nama, tipe, harga per jam)
- CRUD jadwal per lapangan (hari, jam mulai, jam selesai)
- Booking: pilih jadwal + tanggal, isi data penyewa, total dihitung dari durasi x harga
- Satu booking per jadwal per tanggal (unique), status: pending / konfirmasi / batal
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    lapangan ||--o{ jadwal : memiliki
    users ||--o{ booking : mencatat
    jadwal ||--o{ booking : dipesan

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    lapangan {
        int id PK
        varchar nama
        varchar tipe
        decimal harga_per_jam
    }
    jadwal {
        int id PK
        int lapangan_id FK
        enum hari
        time jam_mulai
        time jam_selesai
    }
    booking {
        int id PK
        int user_id FK
        int jadwal_id FK
        varchar nama_pelanggan
        varchar telepon
        date tanggal
        enum status
        decimal total_harga
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
