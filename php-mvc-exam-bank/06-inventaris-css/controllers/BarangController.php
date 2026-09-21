<?php

class BarangController
{
    private $barangModel;
    private $kategoriModel;

    public function __construct($pdo)
    {
        $this->barangModel = new Barang($pdo);
        $this->kategoriModel = new Kategori($pdo);
    }

    public function index()
    {
        $barang = $this->barangModel->all();
        include __DIR__ . '/../views/barang/index.php';
    }

    public function form()
    {
        $kategori = $this->kategoriModel->all();
        $id = $_GET['id'] ?? null;
        $barang = $id ? $this->barangModel->find($id) : null;
        include __DIR__ . '/../views/barang/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $kategoriId = (int)($_POST['kategori_id'] ?? 0);
        $stok = (int)($_POST['stok'] ?? 0);
        $lokasi = trim($_POST['lokasi'] ?? '');

        if ($nama === '' || $kategoriId <= 0 || $stok < 0) {
            $_SESSION['flash_error'] = 'Nama, kategori wajib diisi dan stok tidak boleh negatif';
        } else {
            if ($id !== '') {
                $this->barangModel->update($id, $nama, $kategoriId, $stok, $lokasi);
                $_SESSION['flash_sukses'] = 'Barang berhasil diupdate';
            } else {
                $this->barangModel->create($nama, $kategoriId, $stok, $lokasi);
                $_SESSION['flash_sukses'] = 'Barang berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=barang');
        exit;
    }

    public function hapus()
    {
        $this->barangModel->delete($_GET['id'] ?? 0);
        $_SESSION['flash_sukses'] = 'Barang berhasil dihapus';
        header('Location: index.php?page=barang');
        exit;
    }
}
