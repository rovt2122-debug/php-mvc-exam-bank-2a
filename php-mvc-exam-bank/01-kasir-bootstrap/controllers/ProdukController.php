<?php

class ProdukController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Produk($pdo);
    }

    public function index()
    {
        $produk = $this->model->all();
        include __DIR__ . '/../views/produk/index.php';
    }

    public function form()
    {
        // kalau ada id berarti mode edit
        $id = $_GET['id'] ?? null;
        $produk = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/produk/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $harga = (int)($_POST['harga'] ?? 0);

        if ($nama === '' || $harga <= 0) {
            $_SESSION['flash_error'] = 'Nama dan harga produk wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $harga);
                $_SESSION['flash_sukses'] = 'Produk berhasil diupdate';
            } else {
                $this->model->create($nama, $harga);
                $_SESSION['flash_sukses'] = 'Produk berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=produk');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Produk berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, produk masih dipakai di transaksi
            $_SESSION['flash_error'] = 'Produk tidak bisa dihapus karena sudah pernah dipakai di transaksi';
        }
        header('Location: index.php?page=produk');
        exit;
    }
}
