<?php

class LapanganController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Lapangan($pdo);
    }

    public function index()
    {
        $lapangan = $this->model->all();
        include __DIR__ . '/../views/lapangan/index.php';
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $lapangan = $id ? $this->model->find($id) : null;
        include __DIR__ . '/../views/lapangan/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $jenis = trim($_POST['jenis'] ?? '');

        if ($nama === '') {
            $_SESSION['flash_error'] = 'Nama lapangan wajib diisi';
        } else {
            if ($id !== '') {
                $this->model->update($id, $nama, $jenis);
                $_SESSION['flash_sukses'] = 'Lapangan berhasil diupdate';
            } else {
                $this->model->create($nama, $jenis);
                $_SESSION['flash_sukses'] = 'Lapangan berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=lapangan');
        exit;
    }

    public function hapus()
    {
        try {
            $this->model->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Lapangan berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, lapangan masih dipakai di jadwal/booking
            $_SESSION['flash_error'] = 'Lapangan tidak bisa dihapus karena masih dipakai di jadwal atau booking';
        }
        header('Location: index.php?page=lapangan');
        exit;
    }
}
