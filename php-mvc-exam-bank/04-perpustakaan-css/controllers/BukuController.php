<?php

class BukuController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Buku($pdo);
    }

    public function index()
    {
        $buku = $this->model->all();
        include __DIR__ . '/../views/buku/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $buku = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/buku/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $judul = trim($_POST['judul'] ?? '');
        $pengarang = trim($_POST['pengarang'] ?? '');
        $tahun = (int)($_POST['tahun'] ?? 0);
        $stok = (int)($_POST['stok'] ?? 0);

        if ($judul === '' || $stok < 0) {
            $_SESSION['flash_error'] = 'Judul wajib diisi dan stok tidak boleh negatif';
        } else {
            if ($id !== '') {
                $this->model->update($id, $judul, $pengarang, $tahun, $stok);
                $_SESSION['flash_sukses'] = 'Buku berhasil diupdate';
            } else {
                $this->model->create($judul, $pengarang, $tahun, $stok);
                $_SESSION['flash_sukses'] = 'Buku berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=buku');
        exit;
    }

    public function hapus()
    {
        $this->model->delete($_GET['id'] ?? 0);
        $_SESSION['flash_sukses'] = 'Buku berhasil dihapus';
        header('Location: index.php?page=buku');
        exit;
    }
}
