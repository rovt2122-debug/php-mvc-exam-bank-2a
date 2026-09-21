<?php

class SiswaController
{
    private $siswaModel;
    private $kelasModel;

    public function __construct($pdo)
    {
        $this->siswaModel = new Siswa($pdo);
        $this->kelasModel = new Kelas($pdo);
    }

    public function index()
    {
        $siswa = $this->siswaModel->all();
        include __DIR__ . '/../views/siswa/index.php';
    }

    public function form()
    {
        $kelas = $this->kelasModel->all();
        $id = $_GET['id'] ?? null;
        $siswa = $id ? $this->siswaModel->find($id) : null;
        include __DIR__ . '/../views/siswa/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $nama = trim($_POST['nama'] ?? '');
        $kelasId = (int)($_POST['kelas_id'] ?? 0);

        if ($nama === '' || $kelasId <= 0) {
            $_SESSION['flash_error'] = 'Nama dan kelas wajib diisi';
        } else {
            if ($id !== '') {
                $this->siswaModel->update($id, $nama, $kelasId);
                $_SESSION['flash_sukses'] = 'Siswa berhasil diupdate';
            } else {
                $this->siswaModel->create($nama, $kelasId);
                $_SESSION['flash_sukses'] = 'Siswa berhasil ditambahkan';
            }
        }
        header('Location: index.php?page=siswa');
        exit;
    }

    public function hapus()
    {
        try {
            $this->siswaModel->delete($_GET['id'] ?? 0);
            $_SESSION['flash_sukses'] = 'Siswa berhasil dihapus';
        } catch (PDOException $e) {
            // kode 23000 = pelanggaran foreign key, siswa masih dipakai di absensi
            $_SESSION['flash_error'] = 'Siswa tidak bisa dihapus karena masih punya riwayat absensi';
        }
        header('Location: index.php?page=siswa');
        exit;
    }
}
