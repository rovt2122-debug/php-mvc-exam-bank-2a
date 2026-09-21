import { readFileSync, writeFileSync } from 'fs';

const ROOT = '/vercel/share/v0-project/php-mvc-exam-bank';
const T = (f) => readFileSync(`/vercel/share/v0-project/.gen/templates/${f}`, 'utf8');

const li = (page, label) =>
  `<li class="nav-item"><a class="nav-link" href="index.php?page=${page}">${label}</a></li>`;
const a = (page, label) => `<a href="index.php?page=${page}">${label}</a>`;

const apps = [
  {
    folder: '01-kasir-bootstrap', ui: 'bootstrap', db: 'db_kasir', nama: 'Kasir Sederhana',
    nav: li('produk', 'Produk') + li('kasir', 'Kasir') + li('riwayat', 'Riwayat Transaksi'),
  },
  {
    folder: '02-laundry-css', ui: 'css', db: 'db_laundry', nama: 'Laundry Sederhana',
    nav: a('pelanggan', 'Pelanggan') + a('layanan', 'Layanan') + a('transaksi', 'Transaksi'),
  },
  {
    folder: '03-rental-bootstrap', ui: 'bootstrap', db: 'db_rental', nama: 'Rental Kendaraan',
    nav: li('kendaraan', 'Kendaraan') + li('pelanggan', 'Pelanggan') + li('transaksi', 'Transaksi Rental'),
  },
  {
    folder: '04-perpustakaan-css', ui: 'css', db: 'db_perpustakaan', nama: 'Perpustakaan Sederhana',
    nav: a('buku', 'Buku') + a('anggota', 'Anggota') + a('peminjaman', 'Peminjaman'),
  },
  {
    folder: '05-absensi-bootstrap', ui: 'bootstrap', db: 'db_absensi', nama: 'Absensi Siswa',
    nav: li('kelas', 'Kelas') + li('siswa', 'Siswa') + li('absensi', 'Absensi'),
  },
  {
    folder: '06-inventaris-css', ui: 'css', db: 'db_inventaris', nama: 'Inventaris Barang',
    nav: a('kategori', 'Kategori') + a('barang', 'Barang') + a('stok', 'Stok'),
  },
  {
    folder: '07-booking-lapangan-bootstrap', ui: 'bootstrap', db: 'db_booking', nama: 'Booking Lapangan',
    nav: li('lapangan', 'Lapangan') + li('jadwal', 'Jadwal') + li('booking', 'Booking'),
  },
  {
    folder: '08-pengaduan-fasilitas-css', ui: 'css', db: 'db_pengaduan', nama: 'Pengaduan Fasilitas',
    nav: a('kategori', 'Kategori') + a('pengaduan', 'Pengaduan'),
  },
];

for (const app of apps) {
  const base = `${ROOT}/${app.folder}`;
  const fill = (s) =>
    s.replaceAll('{{DB_NAME}}', app.db).replaceAll('{{APP_NAME}}', app.nama).replaceAll('{{NAV_LINKS}}', app.nav);

  writeFileSync(`${base}/config/database.php`, fill(T('config-database.php')));
  writeFileSync(`${base}/controllers/AuthController.php`, T('AuthController.php'));
  writeFileSync(`${base}/models/User.php`, T('User.php'));
  writeFileSync(`${base}/views/auth/login.php`, fill(T(`login-${app.ui}.php`)));
  writeFileSync(`${base}/views/auth/signup.php`, fill(T(`signup-${app.ui}.php`)));
  writeFileSync(`${base}/views/partials/header.php`, fill(T(`header-${app.ui}.php`)));
  writeFileSync(`${base}/views/partials/footer.php`, T('footer.php'));
  writeFileSync(`${base}/assets/js/app.js`, T('app.js'));
  if (app.ui === 'css') writeFileSync(`${base}/assets/css/style.css`, T('style.css'));
  console.log('ok', app.folder);
}
