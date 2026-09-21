<?php
// nama session unik per app, supaya session tidak bocor antar study case
// yang dijalankan di domain localhost yang sama
session_name('exam05_absensi');
session_start();

// BASE_URL = path URL folder app ini, dipakai untuk mengakses assets
// baik dari root index.php maupun public/index.php
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', preg_replace('~(/public)$~', '', $scriptDir));

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Kelas.php';
require __DIR__ . '/../models/Siswa.php';
require __DIR__ . '/../models/Absensi.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/KelasController.php';
require __DIR__ . '/../controllers/SiswaController.php';
require __DIR__ . '/../controllers/AbsensiController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'absensi';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'kelas': (new KelasController($pdo))->index(); break;
    case 'kelas-form': (new KelasController($pdo))->form(); break;
    case 'kelas-simpan': (new KelasController($pdo))->simpan(); break;
    case 'kelas-hapus': (new KelasController($pdo))->hapus(); break;

    case 'siswa': (new SiswaController($pdo))->index(); break;
    case 'siswa-form': (new SiswaController($pdo))->form(); break;
    case 'siswa-simpan': (new SiswaController($pdo))->simpan(); break;
    case 'siswa-hapus': (new SiswaController($pdo))->hapus(); break;

    case 'absensi': (new AbsensiController($pdo))->index(); break;
    case 'absensi-form': (new AbsensiController($pdo))->form(); break;
    case 'absensi-simpan': (new AbsensiController($pdo))->simpan(); break;
    case 'absensi-edit': (new AbsensiController($pdo))->edit(); break;
    case 'absensi-update': (new AbsensiController($pdo))->update(); break;
    case 'absensi-hapus': (new AbsensiController($pdo))->hapus(); break;

    default: echo 'Halaman tidak ditemukan';
}
