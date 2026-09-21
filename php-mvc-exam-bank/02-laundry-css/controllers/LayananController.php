<?php

class LayananController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Layanan($pdo);
    }

    public function index()
    {
        $layanan = $this->model->all();
        include __DIR__ . '/../views/layanan/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $layanan = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/layanan/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $hargaPerKg = (int)($_POST['harga_per_kg'] ?? 0);
        $biayaTambahan = (int)($_POST['biaya_tambahan'] ?? 0);

        if ($nama === '' || $hargaPerKg <= 0) {
            $_SESSION['flash_error'] = 'Nama dan harga per kg wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $hargaPerKg, $biayaTambahan);
                $_SESSION['flash_sukses'] = 'Layanan berhasil diupdate';
            } else {
                $this->model->create($nama, $hargaPerKg, $biayaTambahan);
                $_SESSION['flash_sukses'] = 'Layanan berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=layanan');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Layanan berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, layanan masih dipakai di transaksi
            $_SESSION['flash_error'] = 'Layanan tidak bisa dihapus karena masih dipakai di transaksi';
        }
        header('Location: index.php?page=layanan');
        exit;
    }
}
