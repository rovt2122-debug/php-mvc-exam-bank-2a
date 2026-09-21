<?php

class JadwalController
{
    private $jadwalModel;
    private $lapanganModel;

    public function __construct($pdo)
    {
        $this->jadwalModel = new Jadwal($pdo);
        $this->lapanganModel = new Lapangan($pdo);
    }

    public function index()
    {
        $jadwal = $this->jadwalModel->all();
        include __DIR__ . '/../views/jadwal/index.php';
    }

    public function form()
    {
        $lapangan = $this->lapanganModel->all();
        $id = $_GET['id'] ?? null;
        $jadwal = $id ? $this->jadwalModel->find($id) : null;
        include __DIR__ . '/../views/jadwal/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $lapanganId = (int)($_POST['lapangan_id'] ?? 0);
        $jamMulai = $_POST['jam_mulai'] ?? '';
        $jamSelesai = $_POST['jam_selesai'] ?? '';
        $hargaPerJam = (int)($_POST['harga_per_jam'] ?? 0);

        if ($lapanganId <= 0 || $hargaPerJam <= 0) {
            $_SESSION['flash_error'] = 'Lapangan dan harga per jam wajib diisi';
            header('Location: index.php?page=jadwal-form');
            exit;
        }

        // jam selesai harus lebih besar dari jam mulai
        if ($jamMulai === '' || $jamSelesai === '' || $jamSelesai <= $jamMulai) {
            $_SESSION['flash_error'] = 'Jam selesai harus lebih besar dari jam mulai';
            header('Location: index.php?page=jadwal-form');
            exit;
        }

        if ($id !== '') {
            $this->jadwalModel->update($id, $lapanganId, $jamMulai, $jamSelesai, $hargaPerJam);
            $_SESSION['flash_sukses'] = 'Jadwal berhasil diupdate';
        } else {
            $this->jadwalModel->create($lapanganId, $jamMulai, $jamSelesai, $hargaPerJam);
            $_SESSION['flash_sukses'] = 'Jadwal berhasil ditambahkan';
        }
        header('Location: index.php?page=jadwal');
        exit;
    }

    public function hapus()
    {
        try {
            $this->jadwalModel->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Jadwal berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, jadwal masih dipakai di booking
            $_SESSION['flash_error'] = 'Jadwal tidak bisa dihapus karena masih dipakai di booking';
        }
        header('Location: index.php?page=jadwal');
        exit;
    }
}
