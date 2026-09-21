# 01 — Kasir / Point of Sale (Bootstrap 5)

Aplikasi kasir sederhana: kelola produk, buat transaksi penjualan dengan banyak item, dan lihat riwayat transaksi.

## Fitur

- CRUD produk (nama, harga, stok)
- Halaman kasir: pilih produk, atur jumlah, simpan transaksi (stok otomatis berkurang)
- Riwayat transaksi + detail item per transaksi
- Login & Sign Up (password bcrypt + session)

## ERD

```mermaid
erDiagram
    users ||--o{ transaksi : melakukan
    transaksi ||--|{ transaksi_detail : memiliki
    produk ||--o{ transaksi_detail : terjual

    users {
        int id PK
        varchar nama
        varchar email UK
        varchar password
        timestamp created_at
    }
    produk {
        int id PK
        varchar nama
        decimal harga
        int stok
    }
    transaksi {
        int id PK
        int user_id FK
        decimal total
        timestamp created_at
    }
    transaksi_detail {
        int id PK
        int transaksi_id FK
        int produk_id FK
        int jumlah
        decimal harga_saat_itu
        decimal subtotal
    }
```

## Menjalankan

```bash
mysql -u root -p < database.sql
php -S localhost:8000 -t public
```

Login: `admin@demo.test` / `admin123`
