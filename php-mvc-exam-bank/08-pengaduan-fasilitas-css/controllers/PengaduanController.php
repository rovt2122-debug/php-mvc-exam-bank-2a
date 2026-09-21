<?php

class PengaduanController
{
    private $pengaduanModel;
    private $kategoriModel;

    public function __construct($pdo)
    {
        $this->pengaduanModel = new Pengaduan($pdo);
        $this->kategoriModel = new Kategori($pdo);
    }

    // cek apakah pengaduan boleh diedit/dihapus oleh user yang sedang login
    private function bolehUbah($pengaduan)
    {
        if (!$pengaduan) {
            return false;
        }

        // cuma pengaduan yang masih diajukan yang boleh diubah
        if ($pengaduan['status'] !== 'diajukan') {
            return false;
        }

        $admin = ($_SESSION['user_role'] ?? '') === 'admin';
        $pemilik = (int)$pengaduan['user_id'] === (int)$_SESSION['user_id'];

        return $admin || $pemilik;
    }

    public function index()
    {
        // admin lihat semua, user biasa cuma lihat pengaduannya sendiri
        $admin = ($_SESSION['user_role'] ?? '') === 'admin';
        $filterUser = $admin ? null : $_SESSION['user_id'];

        // pagination 8 data per halaman
        $perPage = 8;
        $totalData = $this->pengaduanModel->countAll($filterUser);
        $totalHalaman = max(1, (int)ceil($totalData / $perPage));
        $halaman = min(max(1, (int)($_GET['halaman'] ?? 1)), $totalHalaman);

        $pengaduan = $this->pengaduanModel->page($filterUser, $perPage, ($halaman - 1) * $perPage);
        include __DIR__ . '/../views/pengaduan/index.php';
    }

    public function form()
    {
        $kategori = $this->kategoriModel->all();
        $id = $_GET['id'] ?? null;
        $pengaduan = null;

        if ($id) {
            $pengaduan = $this->pengaduanModel->find($id);
            if (!$this->bolehUbah($pengaduan)) {
                $_SESSION['flash_error'] = 'Pengaduan yang sudah diproses tidak bisa diedit';
                header('Location: index.php?page=pengaduan');
                exit;
            }
        }
        include __DIR__ . '/../views/pengaduan/form.php';
    }

    public function simpan()
    {
        $id = $_POST['id'] ?? '';
        $kategoriId = (int)($_POST['kategori_id'] ?? 0);
        $judul = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');

        if ($kategoriId <= 0 || $judul === '') {
            $_SESSION['flash_error'] = 'Kategori dan judul wajib diisi';
            header('Location: index.php?page=pengaduan-form');
            exit;
        }

        if ($id !== '') {
            $pengaduan = $this->pengaduanModel->find($id);
            if (!$this->bolehUbah($pengaduan)) {
                $_SESSION['flash_error'] = 'Pengaduan ini tidak bisa diedit';
                header('Location: index.php?page=pengaduan');
                exit;
            }
            $this->pengaduanModel->update($id, $kategoriId, $judul, $deskripsi, $lokasi);
            $_SESSION['flash_sukses'] = 'Pengaduan berhasil diupdate';
        } else {
            $this->pengaduanModel->create($_SESSION['user_id'], $kategoriId, $judul, $deskripsi, $lokasi);
            $_SESSION['flash_sukses'] = 'Pengaduan berhasil dikirim';
        }
        header('Location: index.php?page=pengaduan');
        exit;
    }

    public function status()
    {
        // cuma admin yang boleh ubah status
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            header('Location: index.php?page=pengaduan');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? '';
        $boleh = ['diajukan', 'diproses', 'selesai'];

        if ($id > 0 && in_array($status, $boleh)) {
            $this->pengaduanModel->updateStatus($id, $status);
            $_SESSION['flash_sukses'] = 'Status pengaduan diupdate jadi ' . $status;
        }
        header('Location: index.php?page=pengaduan');
        exit;
    }

    public function hapus()
    {
        $id = (int)($_GET['id'] ?? 0);
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$this->bolehUbah($pengaduan)) {
            $_SESSION['flash_error'] = 'Pengaduan ini tidak bisa dihapus';
            header('Location: index.php?page=pengaduan');
            exit;
        }

        $this->pengaduanModel->delete($id);
        $_SESSION['flash_sukses'] = 'Pengaduan berhasil dihapus';
        header('Location: index.php?page=pengaduan');
        exit;
    }
}
