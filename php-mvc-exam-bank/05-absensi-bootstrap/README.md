# 05 — Absensi Siswa (Bootstrap 5)

Aplikasi absensi sekolah: kelola kelas dan siswa, lalu catat kehadiran harian per kelas dengan rekap.

## Fitur

- CRUD kelas (nama, tingkat)
- CRUD siswa (nis, nama, kelas)
- Absensi harian per kelas: hadir / izin / sakit / alpa, satu entri per siswa per tanggal (unique)
- Rekap absensi per tanggal
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    kelas ||--o{ siswa : berisi
    users ||--o{ absensi : mencatat
    siswa ||--o{ absensi : memiliki

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
    }
    kelas {
        int id PK
        varchar nama
        varchar tingkat
    }
    siswa {
        int id PK
        int kelas_id FK
        varchar nis UK
        varchar nama
    }
    absensi {
        int id PK
        int user_id FK
        int siswa_id FK
        date tanggal
        enum status
        varchar keterangan
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
