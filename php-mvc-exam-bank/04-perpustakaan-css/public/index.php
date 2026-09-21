<?php
// nama session unik per app, supaya session tidak bocor antar study case
// yang dijalankan di domain localhost yang sama
session_name('exam04_perpus');
session_start();

// BASE_URL = path URL folder app ini, dipakai untuk mengakses assets
// baik dari root index.php maupun public/index.php
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', preg_replace('~(/public)$~', '', $scriptDir));

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Buku.php';
require __DIR__ . '/../models/Anggota.php';
require __DIR__ . '/../models/Peminjaman.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/BukuController.php';
require __DIR__ . '/../controllers/AnggotaController.php';
require __DIR__ . '/../controllers/PeminjamanController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'peminjaman';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'buku': (new BukuController($pdo))->index(); break;
    case 'buku-form': (new BukuController($pdo))->form(); break;
    case 'buku-simpan': (new BukuController($pdo))->simpan(); break;
    case 'buku-hapus': (new BukuController($pdo))->hapus(); break;

    case 'anggota': (new AnggotaController($pdo))->index(); break;
    case 'anggota-form': (new AnggotaController($pdo))->form(); break;
    case 'anggota-simpan': (new AnggotaController($pdo))->simpan(); break;
    case 'anggota-hapus': (new AnggotaController($pdo))->hapus(); break;

    case 'peminjaman': (new PeminjamanController($pdo))->index(); break;
    case 'peminjaman-form': (new PeminjamanController($pdo))->form(); break;
    case 'peminjaman-simpan': (new PeminjamanController($pdo))->simpan(); break;
    case 'peminjaman-kembali': (new PeminjamanController($pdo))->kembali(); break;
    case 'peminjaman-hapus': (new PeminjamanController($pdo))->hapus(); break;

    default: echo 'Halaman tidak ditemukan';
}
