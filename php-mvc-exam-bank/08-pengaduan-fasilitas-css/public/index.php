<?php
// nama session unik per app, supaya session tidak bocor antar study case
// yang dijalankan di domain localhost yang sama
session_name('exam08_pengaduan');
session_start();

// BASE_URL = path URL folder app ini, dipakai untuk mengakses assets
// baik dari root index.php maupun public/index.php
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', preg_replace('~(/public)$~', '', $scriptDir));

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Kategori.php';
require __DIR__ . '/../models/Pengaduan.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/KategoriController.php';
require __DIR__ . '/../controllers/PengaduanController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'pengaduan';

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

    case 'pengaduan': (new PengaduanController($pdo))->index(); break;
    case 'pengaduan-form': (new PengaduanController($pdo))->form(); break;
    case 'pengaduan-simpan': (new PengaduanController($pdo))->simpan(); break;
    case 'pengaduan-status': (new PengaduanController($pdo))->status(); break;
    case 'pengaduan-hapus': (new PengaduanController($pdo))->hapus(); break;

    default: echo 'Halaman tidak ditemukan';
}
