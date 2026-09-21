<?php

class StokController
{
    private $pdo;
    private $barangModel;
    private $riwayatModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->barangModel = new Barang($pdo);
        $this->riwayatModel = new RiwayatStok($pdo);
    }

    public function index()
    {
        $riwayat = $this->riwayatModel->all();
        include __DIR__ . '/../views/stok/index.php';
    }

    public function form()
    {
        $barang = $this->barangModel->all();
        include __DIR__ . '/../views/stok/form.php';
    }

    public function simpan()
    {
        $barangId = (int)($_POST['barang_id'] ?? 0);
        $jenis = $_POST['jenis'] ?? '';
        $jumlah = (int)($_POST['jumlah'] ?? 0);
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($barangId <= 0 || !in_array($jenis, ['masuk', 'keluar']) || $jumlah <= 0) {
            $_SESSION['flash_error'] = 'Barang, jenis, dan jumlah wajib diisi dengan benar';
            header('Location: index.php?page=stok-form');
            exit;
        }

        $barang = $this->barangModel->find($barangId);

        // stok tidak boleh jadi negatif
        if ($jenis === 'keluar' && (int)$barang['stok'] < $jumlah) {
            $_SESSION['flash_error'] = 'Stok tidak cukup, sisa stok ' . $barang['stok'];
            header('Location: index.php?page=stok-form');
            exit;
        }

        // update stok dan catat riwayat dalam satu transaction
        $this->pdo->beginTransaction();
        try {
            if ($jenis === 'masuk') {
                $this->barangModel->tambahStok($barangId, $jumlah);
            } else {
                $this->barangModel->kurangiStok($barangId, $jumlah);
            }
            $this->riwayatModel->create($barangId, $jenis, $jumlah, $keterangan);
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $_SESSION['flash_error'] = 'Gagal menyimpan perubahan stok';
            header('Location: index.php?page=stok-form');
            exit;
        }

        $_SESSION['flash_sukses'] = 'Stok barang ' . $barang['nama'] . ' berhasil diupdate';
        header('Location: index.php?page=stok');
        exit;
    }
}
