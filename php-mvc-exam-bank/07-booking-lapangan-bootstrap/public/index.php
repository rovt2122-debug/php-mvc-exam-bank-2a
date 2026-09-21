<?php
// nama session unik per app, supaya session tidak bocor antar study case
// yang dijalankan di domain localhost yang sama
session_name('exam07_booking');
session_start();

// BASE_URL = path URL folder app ini, dipakai untuk mengakses assets
// baik dari root index.php maupun public/index.php
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', preg_replace('~(/public)$~', '', $scriptDir));

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Lapangan.php';
require __DIR__ . '/../models/Jadwal.php';
require __DIR__ . '/../models/Booking.php';
require __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../controllers/LapanganController.php';
require __DIR__ . '/../controllers/JadwalController.php';
require __DIR__ . '/../controllers/BookingController.php';

// halaman yang bisa dibuka tanpa login
$halamanBebas = ['login', 'signup'];
$page = $_GET['page'] ?? 'booking';

if (!in_array($page, $halamanBebas) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case 'login': (new AuthController($pdo))->login(); break;
    case 'signup': (new AuthController($pdo))->signup(); break;
    case 'logout': (new AuthController($pdo))->logout(); break;

    case 'lapangan': (new LapanganController($pdo))->index(); break;
    case 'lapangan-form': (new LapanganController($pdo))->form(); break;
    case 'lapangan-simpan': (new LapanganController($pdo))->simpan(); break;
    case 'lapangan-hapus': (new LapanganController($pdo))->hapus(); break;

    case 'jadwal': (new JadwalController($pdo))->index(); break;
    case 'jadwal-form': (new JadwalController($pdo))->form(); break;
    case 'jadwal-simpan': (new JadwalController($pdo))->simpan(); break;
    case 'jadwal-hapus': (new JadwalController($pdo))->hapus(); break;

    case 'booking': (new BookingController($pdo))->index(); break;
    case 'booking-form': (new BookingController($pdo))->form(); break;
    case 'booking-simpan': (new BookingController($pdo))->simpan(); break;
    case 'booking-batal': (new BookingController($pdo))->batal(); break;
    case 'booking-hapus': (new BookingController($pdo))->hapus(); break;

    default: echo 'Halaman tidak ditemukan';
}
