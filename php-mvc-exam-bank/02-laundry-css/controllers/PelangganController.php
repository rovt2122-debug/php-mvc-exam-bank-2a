<?php

class PelangganController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Pelanggan($pdo);
    }

    public function index()
    {
        $pelanggan = $this->model->all();
        include __DIR__ . '/../views/pelanggan/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $pelanggan = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/pelanggan/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $telepon = trim($_POST['telepon'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama pelanggan wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $telepon, $alamat);
                $_SESSION['flash_sukses'] = 'Pelanggan berhasil diupdate';
            } else {
                $this->model->create($nama, $telepon, $alamat);
                $_SESSION['flash_sukses'] = 'Pelanggan berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=pelanggan');
        exit;
    }

    public function hapus()
    {
        $this->model->delete($_GET['id'] ?? 0);
        $_SESSION['flash_sukses'] = 'Pelanggan berhasil dihapus';
        header('Location: index.php?page=pelanggan');
        exit;
    }
}
