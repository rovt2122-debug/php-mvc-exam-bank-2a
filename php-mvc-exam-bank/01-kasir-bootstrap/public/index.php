<?php
session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Produk.php';
require __DIR__ . '/../models/Transaksi.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/ProdukController.php';
require __DIR__ . '/../controllers/TransaksiController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'produk';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'produk': (new ProdukController($pdo))->index(); break;
    case 'produk-form': (new ProdukController($pdo))->form(); break;
    case 'produk-simpan': (new ProdukController($pdo))->simpan(); break;
    case 'produk-hapus': (new ProdukController($pdo))->hapus(); break;

    case 'kasir': (new TransaksiController($pdo))->kasir(); break;
    case 'kasir-tambah': (new TransaksiController($pdo))->tambahKeranjang(); break;
    case 'kasir-hapus-item': (new TransaksiController($pdo))->hapusItem(); break;
    case 'kasir-bayar': (new TransaksiController($pdo))->bayar(); break;
    case 'riwayat': (new TransaksiController($pdo))->riwayat(); break;
    case 'transaksi-detail': (new TransaksiController($pdo))->detail(); break;

    default: echo 'Halaman tidak ditemukan';
}
