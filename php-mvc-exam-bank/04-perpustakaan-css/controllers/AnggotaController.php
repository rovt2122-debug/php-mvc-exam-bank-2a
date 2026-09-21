<?php

class AnggotaController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Anggota($pdo);
    }

    public function index()
    {
        $anggota = $this->model->all();
        include __DIR__ . '/../views/anggota/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $anggota = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/anggota/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $nomor = trim($_POST['nomor_anggota'] ?? '');
        $telepon = trim($_POST['telepon'] ?? '');

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama anggota wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $nomor, $telepon);
                $_SESSION['flash_sukses'] = 'Anggota berhasil diupdate';
            } else {
                $this->model->create($nama, $nomor, $telepon);
                $_SESSION['flash_sukses'] = 'Anggota berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=anggota');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Anggota berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, anggota masih dipakai di peminjaman
            $_SESSION['flash_error'] = 'Anggota tidak bisa dihapus karena masih punya riwayat peminjaman';
        }
        header('Location: index.php?page=anggota');
        exit;
    }
}
