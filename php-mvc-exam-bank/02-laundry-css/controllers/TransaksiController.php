<?php

class TransaksiController
{
    private $transaksiModel;
    private $pelangganModel;
    private $layananModel;

    public function __construct($pdo)
    {
        $this->transaksiModel = new Transaksi($pdo);
        $this->pelangganModel = new Pelanggan($pdo);
        $this->layananModel = new Layanan($pdo);
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
        $pelanggan = $this->pelangganModel->all();
        $layanan = $this->layananModel->all();
        include __DIR__ . '/../views/transaksi/form.php';
    }

    public function simpan()
    {
        $pelangganId = (int)($_POST['pelanggan_id'] ?? 0);
        $layananId = (int)($_POST['layanan_id'] ?? 0);
        $berat = (float)($_POST['berat'] ?? 0);
        $tanggalMasuk = $_POST['tanggal_masuk'] ?? date('Y-m-d');

        $layanan = $this->layananModel->find($layananId);

        if ($pelangganId <= 0 || !$layanan || $berat <= 0) {
            $_SESSION['flash_error'] = 'Pelanggan, layanan, dan berat cucian wajib diisi';
            header('Location: index.php?page=transaksi-form');
            exit;
        }

        // total = (harga per kg x berat) + biaya tambahan layanan
        $total = ($layanan['harga_per_kg'] * $berat) + $layanan['biaya_tambahan'];

        $this->transaksiModel->create([
            'pelanggan_id' => $pelangganId,
            'layanan_id' => $layananId,
            'berat' => $berat,
            'harga_per_kg' => $layanan['harga_per_kg'],
            'biaya_tambahan' => $layanan['biaya_tambahan'],
            'total' => $total,
            'tanggal_masuk' => $tanggalMasuk,
        ]);

        $_SESSION['flash_sukses'] = 'Transaksi laundry berhasil disimpan';
        header('Location: index.php?page=transaksi');
        exit;
    }

    public function status()
    {
        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? '';
        $boleh = ['diproses', 'dicuci', 'selesai', 'diambil'];

        // validasi supaya statusnya tidak sembarangan
        if ($id > 0 && in_array($status, $boleh)) {
            $this->transaksiModel->updateStatus($id, $status);
            $_SESSION['flash_sukses'] = 'Status cucian diupdate jadi ' . $status;
        }
        header('Location: index.php?page=transaksi');
        exit;
    }
}
