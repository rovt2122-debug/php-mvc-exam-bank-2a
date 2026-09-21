<?php

class KategoriController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Kategori($pdo);
    }

    public function index()
    {
        $kategori = $this->model->all();
        include __DIR__ . '/../views/kategori/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $kategori = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/kategori/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama kategori wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama);
                $_SESSION['flash_sukses'] = 'Kategori berhasil diupdate';
            } else {
                $this->model->create($nama);
                $_SESSION['flash_sukses'] = 'Kategori berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=kategori');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Kategori berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, kategori masih dipakai di barang
            $_SESSION['flash_error'] = 'Kategori tidak bisa dihapus karena masih dipakai di data barang';
        }
        header('Location: index.php?page=kategori');
        exit;
    }
}
