<?php

class KendaraanController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Kendaraan($pdo);
    }

    public function index()
    {
        $kendaraan = $this->model->all();
        include __DIR__ . '/../views/kendaraan/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $kendaraan = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/kendaraan/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $plat = trim($_POST['plat'] ?? '');
        $hargaPerHari = (int)($_POST['harga_per_hari'] ?? 0);

        if ($nama === '' || $hargaPerHari <= 0) {
            $_SESSION['flash_error'] = 'Nama dan harga per hari wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $plat, $hargaPerHari);
                $_SESSION['flash_sukses'] = 'Kendaraan berhasil diupdate';
            } else {
                $this->model->create($nama, $plat, $hargaPerHari);
                $_SESSION['flash_sukses'] = 'Kendaraan berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=kendaraan');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Kendaraan berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, kendaraan masih dipakai di transaksi
            $_SESSION['flash_error'] = 'Kendaraan tidak bisa dihapus karena masih punya riwayat transaksi';
        }
        header('Location: index.php?page=kendaraan');
        exit;
    }
}
