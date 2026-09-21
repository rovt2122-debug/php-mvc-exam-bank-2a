<?php

class TransaksiController
{
    private $transaksiModel;
    private $kendaraanModel;
    private $pelangganModel;

    public function __construct($pdo)
    {
        $this->transaksiModel = new Transaksi($pdo);
        $this->kendaraanModel = new Kendaraan($pdo);
        $this->pelangganModel = new Pelanggan($pdo);
    }

    public function index()
    {
        // pagination 8 data per halaman
        $perPage = 8;
        $totalData = $this->transaksiModel->countAll();
        $totalHalaman = max(1, (int)ceil($totalData / $perPage));
        $halaman = min(max(1, (int)($_GET['halaman'] ?? 1)), $totalHalaman);

        $transaksi = $this->transaksiModel->page($perPage, ($halaman - 1) * $perPage);
        include __DIR__ . '/../views/transaksi/index.php';
    }

    // melunasi transaksi yang statusnya belum lunas
    public function lunas()
    {
        $id = (int)($_GET['id'] ?? 0);
        $transaksi = $this->transaksiModel->find($id);

        if ($transaksi && $transaksi['status'] !== 'lunas') {
            $this->transaksiModel->tandaiLunas($id);
            $_SESSION['flash_sukses'] = 'Transaksi ditandai lunas';
        }
        header('Location: index.php?page=transaksi');
        exit;
    }

    public function hapus()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && $this->transaksiModel->hapus($id)) {
            $_SESSION['flash_sukses'] = 'Transaksi berhasil dihapus';
        } else {
            $_SESSION['flash_error'] = 'Transaksi gagal dihapus';
        }
        header('Location: index.php?page=transaksi');
        exit;
    }

    public function form()
    {
        $kendaraan = $this->kendaraanModel->all();
        $pelanggan = $this->pelangganModel->all();
        include __DIR__ . '/../views/transaksi/form.php';
    }

    public function simpan()
    {
        $kendaraanId = (int)($_POST['kendaraan_id'] ?? 0);
        $pelangganId = (int)($_POST['pelanggan_id'] ?? 0);
        $bayar = (int)($_POST['bayar'] ?? 0);

        // input datetime-local formatnya Y-m-d\TH:i
        $mulai = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['tanggal_mulai'] ?? '');
        $selesai = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['tanggal_selesai'] ?? '');

        $kendaraan = $this->kendaraanModel->find($kendaraanId);

        if ($kendaraanId <= 0 || $pelangganId <= 0 || !$kendaraan) {
            $_SESSION['flash_error'] = 'Kendaraan dan pelanggan wajib dipilih';
            header('Location: index.php?page=transaksi-form');
            exit;
        }

        // tanggal selesai tidak boleh sebelum atau sama dengan tanggal mulai
        if (!$mulai || !$selesai || $selesai <= $mulai) {
            $_SESSION['flash_error'] = 'Tanggal selesai harus lebih besar dari tanggal mulai';
            header('Location: index.php?page=transaksi-form');
            exit;
        }

        // hitung jumlah hari pakai DateTime diff, minimal 1 hari
        $jumlahHari = (int)$mulai->diff($selesai)->days;
        if ($jumlahHari < 1) {
            $jumlahHari = 1;
        }

        $hargaPerHari = (int)$kendaraan['harga_per_hari'];
        $total = $jumlahHari * $hargaPerHari;

        // transaksi dianggap lunas kalau pembayaran mencukupi total
        if ($bayar >= $total) {
            $status = 'lunas';
            $kembalian = $bayar - $total;
        } else {
            $status = 'belum lunas';
            $kembalian = 0;
        }

        $this->transaksiModel->create([
            'kendaraan_id' => $kendaraanId,
            'pelanggan_id' => $pelangganId,
            'tanggal_mulai' => $mulai->format('Y-m-d H:i:s'),
            'tanggal_selesai' => $selesai->format('Y-m-d H:i:s'),
            'harga_per_hari' => $hargaPerHari,
            'jumlah_hari' => $jumlahHari,
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'status' => $status,
        ]);

        $_SESSION['flash_sukses'] = 'Transaksi rental berhasil disimpan';
        header('Location: index.php?page=transaksi');
        exit;
    }
}
