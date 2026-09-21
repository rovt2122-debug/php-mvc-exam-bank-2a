<?php
// nama session unik per app, supaya session tidak bocor antar study case
// yang dijalankan di domain localhost yang sama
session_name('exam02_laundry');
session_start();

// BASE_URL = path URL folder app ini, dipakai untuk mengakses assets
// baik dari root index.php maupun public/index.php
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', preg_replace('~(/public)$~', '', $scriptDir));

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Pelanggan.php';
require __DIR__ . '/../models/Layanan.php';
require __DIR__ . '/../models/Transaksi.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/PelangganController.php';
require __DIR__ . '/../controllers/LayananController.php';
require __DIR__ . '/../controllers/TransaksiController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'transaksi';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'pelanggan': (new PelangganController($pdo))->index(); break;
    case 'pelanggan-form': (new PelangganController($pdo))->form(); break;
    case 'pelanggan-simpan': (new PelangganController($pdo))->simpan(); break;
    case 'pelanggan-hapus': (new PelangganController($pdo))->hapus(); break;

    case 'layanan': (new LayananController($pdo))->index(); break;
    case 'layanan-form': (new LayananController($pdo))->form(); break;
    case 'layanan-simpan': (new LayananController($pdo))->simpan(); break;
    case 'layanan-hapus': (new LayananController($pdo))->hapus(); break;

    case 'transaksi': (new TransaksiController($pdo))->index(); break;
    case 'transaksi-form': (new TransaksiController($pdo))->form(); break;
    case 'transaksi-simpan': (new TransaksiController($pdo))->simpan(); break;
    case 'transaksi-status': (new TransaksiController($pdo))->status(); break;
    case 'transaksi-hapus': (new TransaksiController($pdo))->hapus(); break;

    default: echo 'Halaman tidak ditemukan';
}
