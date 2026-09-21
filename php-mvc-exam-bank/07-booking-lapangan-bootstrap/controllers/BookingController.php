<?php

class BookingController
{
    private $bookingModel;
    private $lapanganModel;
    private $jadwalModel;

    public function __construct($pdo)
    {
        $this->bookingModel = new Booking($pdo);
        $this->lapanganModel = new Lapangan($pdo);
        $this->jadwalModel = new Jadwal($pdo);
    }

    public function index()
    {
        // pagination 8 data per halaman
        $perPage = 8;
        $totalData = $this->bookingModel->countAll();
        $totalHalaman = max(1, (int)ceil($totalData / $perPage));
        $halaman = min(max(1, (int)($_GET['halaman'] ?? 1)), $totalHalaman);

        $booking = $this->bookingModel->page($perPage, ($halaman - 1) * $perPage);
        include __DIR__ . '/../views/booking/index.php';
    }

    public function form()
    {
        $lapangan = $this->lapanganModel->all();
        $jadwal = $this->jadwalModel->all();
        include __DIR__ . '/../views/booking/form.php';
    }

    public function simpan()
    {
        $lapanganId = (int)($_POST['lapangan_id'] ?? 0);
        $jadwalId = (int)($_POST['jadwal_id'] ?? 0);
        $tanggal = $_POST['tanggal'] ?? '';
        $jamMulai = $_POST['jam_mulai'] ?? '';
        $jamSelesai = $_POST['jam_selesai'] ?? '';

        $jadwal = $this->jadwalModel->find($jadwalId);

        if ($lapanganId <= 0 || !$jadwal || $tanggal === '') {
            $_SESSION['flash_error'] = 'Lapangan, jadwal, dan tanggal wajib diisi';
            header('Location: index.php?page=booking-form');
            exit;
        }

        // jam selesai harus lebih besar dari jam mulai
        if ($jamMulai === '' || $jamSelesai === '' || $jamSelesai <= $jamMulai) {
            $_SESSION['flash_error'] = 'Jam selesai harus lebih besar dari jam mulai';
            header('Location: index.php?page=booking-form');
            exit;
        }

        // lapangan tidak boleh dibooking di waktu yang bentrok
        $bentrok = $this->bookingModel->cekBentrok($lapanganId, $tanggal, $jamMulai, $jamSelesai);
        if ($bentrok) {
            $_SESSION['flash_error'] = 'Jadwal bentrok, lapangan sudah dibooking di waktu itu';
            header('Location: index.php?page=booking-form');
            exit;
        }

        // durasi dalam jam, bisa pecahan misal 1.5 jam
        $durasi = (strtotime($jamSelesai) - strtotime($jamMulai)) / 3600;
        $total = round($durasi * $jadwal['harga_per_jam']);

        $this->bookingModel->create([
            'lapangan_id' => $lapanganId,
            'jadwal_id' => $jadwalId,
            'tanggal' => $tanggal,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'durasi' => $durasi,
            'total' => $total,
        ]);

        $_SESSION['flash_sukses'] = 'Booking berhasil disimpan, total Rp' . number_format($total, 0, ',', '.');
        header('Location: index.php?page=booking');
        exit;
    }

    public function batal()
    {
        $id = (int)($_GET['id'] ?? 0);
        $booking = $this->bookingModel->find($id);

        if ($booking && $booking['status'] === 'aktif') {
            $this->bookingModel->batal($id);
            $_SESSION['flash_sukses'] = 'Booking dibatalkan';
        }
        header('Location: index.php?page=booking');
        exit;
    }

    public function hapus()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && $this->bookingModel->hapus($id)) {
            $_SESSION['flash_sukses'] = 'Booking berhasil dihapus';
        } else {
            $_SESSION['flash_error'] = 'Booking gagal dihapus';
        }
        header('Location: index.php?page=booking');
        exit;
    }
}
