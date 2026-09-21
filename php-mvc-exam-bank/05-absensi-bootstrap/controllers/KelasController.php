<?php

class KelasController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Kelas($pdo);
    }

    public function index()
    {
        $kelas = $this->model->all();
        include __DIR__ . '/../views/kelas/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $kelas = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/kelas/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama kelas wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama);
                $_SESSION['flash_sukses'] = 'Kelas berhasil diupdate';
            } else {
                $this->model->create($nama);
                $_SESSION['flash_sukses'] = 'Kelas berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=kelas');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Kelas berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, kelas masih dipakai di siswa
            $_SESSION['flash_error'] = 'Kelas tidak bisa dihapus karena masih ada siswa di kelas ini';
        }
        header('Location: index.php?page=kelas');
        exit;
    }
}
