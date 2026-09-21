<?php
session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Kategori.php';
require __DIR__ . '/../models/Barang.php';
require __DIR__ . '/../models/RiwayatStok.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/KategoriController.php';
require __DIR__ . '/../controllers/BarangController.php';
require __DIR__ . '/../controllers/StokController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'barang';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'kategori': (new KategoriController($pdo))->index(); break;
    case 'kategori-form': (new KategoriController($pdo))->form(); break;
    case 'kategori-simpan': (new KategoriController($pdo))->simpan(); break;
    case 'kategori-hapus': (new KategoriController($pdo))->hapus(); break;

    case 'barang': (new BarangController($pdo))->index(); break;
    case 'barang-form': (new BarangController($pdo))->form(); break;
    case 'barang-simpan': (new BarangController($pdo))->simpan(); break;
    case 'barang-hapus': (new BarangController($pdo))->hapus(); break;

    case 'stok': (new StokController($pdo))->index(); break;
    case 'stok-form': (new StokController($pdo))->form(); break;
    case 'stok-simpan': (new StokController($pdo))->simpan(); break;

    default: echo 'Halaman tidak ditemukan';
}
