<?php

class PeminjamanController
{
    private $pdo;
    private $peminjamanModel;
    private $bukuModel;
    private $anggotaModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->peminjamanModel = new Peminjaman($pdo);
        $this->bukuModel = new Buku($pdo);
        $this->anggotaModel = new Anggota($pdo);
    }

    public function index()
    {
        // pagination 8 data per halaman
        $perPage = 8;
        $totalData = $this->peminjamanModel->countAll();
        $totalHalaman = max(1, (int)ceil($totalData / $perPage));
        $halaman = min(max(1, (int)($_GET['halaman'] ?? 1)), $totalHalaman);

        $peminjaman = $this->peminjamanModel->page($perPage, ($halaman - 1) * $perPage);
        include __DIR__ . '/../views/peminjaman/index.php';
    }

    public function form()
    {
        // kalau ada id berarti mode edit (perbaiki tanggal / denda)
        $id = (int)($_GET['id'] ?? 0);
        $pinjam = $id > 0 ? $this->peminjamanModel->findDetail($id) : null;

        if ($pinjam) {
            include __DIR__ . '/../views/peminjaman/form-edit.php';
            return;
        }

        // cuma tampilkan buku yang stoknya masih ada
        $buku = $this->bukuModel->allTersedia();
        $anggota = $this->anggotaModel->all();
        include __DIR__ . '/../views/peminjaman/form.php';
    }

    public function simpan()
    {
        // mode edit: cuma perbaiki tanggal dan denda, buku/anggota tidak berubah
        $editId = (int)($_POST['id'] ?? 0);
        if ($editId > 0) {
            $this->update();
            return;
        }

        $bukuId = (int)($_POST['buku_id'] ?? 0);
        $anggotaId = (int)($_POST['anggota_id'] ?? 0);
        $tanggalPinjam = $_POST['tanggal_pinjam'] ?? date('Y-m-d');
        $tanggalKembali = $_POST['tanggal_kembali'] ?? '';

        $buku = $this->bukuModel->find($bukuId);

        if ($bukuId <= 0 || $anggotaId <= 0 || !$buku) {
            $_SESSION['flash_error'] = 'Buku dan anggota wajib dipilih';
            header('Location: index.php?page=peminjaman-form');
            exit;
        }

        // buku yang stoknya 0 tidak boleh dipinjam
        if ((int)$buku['stok'] <= 0) {
            $_SESSION['flash_error'] = 'Stok buku habis, tidak bisa dipinjam';
            header('Location: index.php?page=peminjaman-form');
            exit;
        }

        if ($tanggalKembali === '' || $tanggalKembali < $tanggalPinjam) {
            $_SESSION['flash_error'] = 'Tanggal kembali harus sama atau setelah tanggal pinjam';
            header('Location: index.php?page=peminjaman-form');
            exit;
        }

        // stok buku dikurangi bersamaan dengan peminjaman
        $this->pdo->beginTransaction();
        try {
            $this->peminjamanModel->create($bukuId, $anggotaId, $tanggalPinjam, $tanggalKembali);
            $this->bukuModel->kurangiStok($bukuId);
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $_SESSION['flash_error'] = 'Peminjaman gagal disimpan';
            header('Location: index.php?page=peminjaman-form');
            exit;
        }

        $_SESSION['flash_sukses'] = 'Peminjaman berhasil disimpan';
        header('Location: index.php?page=peminjaman');
        exit;
    }

    public function kembali()
    {
        $id = (int)($_GET['id'] ?? 0);
        $pinjam = $this->peminjamanModel->find($id);

        if (!$pinjam || $pinjam['status'] !== 'dipinjam') {
            header('Location: index.php?page=peminjaman');
            exit;
        }

        // hitung keterlambatan pakai DateTime
        $jatuhTempo = new DateTime($pinjam['tanggal_kembali']);
        $hariIni = new DateTime(date('Y-m-d'));
        $denda = 0;

        if ($hariIni > $jatuhTempo) {
            $terlambat = (int)$jatuhTempo->diff($hariIni)->days;
            $denda = $terlambat * 1000; // denda 1000 per hari keterlambatan
        }

        // stok buku dikembalikan bersamaan dengan pengembalian
        $this->pdo->beginTransaction();
        try {
            $this->peminjamanModel->kembalikan($id, $denda);
            $this->bukuModel->tambahStok($pinjam['buku_id']);
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $_SESSION['flash_error'] = 'Pengembalian gagal disimpan';
            header('Location: index.php?page=peminjaman');
            exit;
        }

        if ($denda > 0) {
            $_SESSION['flash_sukses'] = 'Buku dikembalikan, denda terlambat Rp' . number_format($denda, 0, ',', '.');
        } else {
            $_SESSION['flash_sukses'] = 'Buku dikembalikan tepat waktu, tidak ada denda';
        }
        header('Location: index.php?page=peminjaman');
        exit;
    }

    // simpan hasil edit tanggal dan denda
    public function update()
    {
        $id = (int)($_POST['id'] ?? 0);
        $pinjam = $this->peminjamanModel->find($id);

        if (!$pinjam) {
            header('Location: index.php?page=peminjaman');
            exit;
        }

        $tanggalPinjam = $_POST['tanggal_pinjam'] ?? '';
        $tanggalKembali = $_POST['tanggal_kembali'] ?? '';
        $denda = max(0, (int)($_POST['denda'] ?? 0));

        if ($tanggalPinjam === '' || $tanggalKembali === '' || $tanggalKembali < $tanggalPinjam) {
            $_SESSION['flash_error'] = 'Tanggal kembali harus sama atau setelah tanggal pinjam';
            header('Location: index.php?page=peminjaman-form&id=' . $id);
            exit;
        }

        $this->peminjamanModel->update($id, $tanggalPinjam, $tanggalKembali, $denda);
        $_SESSION['flash_sukses'] = 'Peminjaman berhasil diupdate';
        header('Location: index.php?page=peminjaman');
        exit;
    }

    public function hapus()
    {
        $id = (int)($_GET['id'] ?? 0);
        $pinjam = $this->peminjamanModel->find($id);

        if (!$pinjam) {
            header('Location: index.php?page=peminjaman');
            exit;
        }

        // kalau bukunya masih dipinjam, stok dikembalikan dulu
        // biarkan stok buku tetap konsisten
        $this->pdo->beginTransaction();
        try {
            if ($pinjam['status'] === 'dipinjam') {
                $this->bukuModel->tambahStok($pinjam['buku_id']);
            }
            $this->peminjamanModel->hapus($id);
            $this->pdo->commit();
            $_SESSION['flash_sukses'] = 'Peminjaman berhasil dihapus';
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $_SESSION['flash_error'] = 'Peminjaman gagal dihapus';
        }
        header('Location: index.php?page=peminjaman');
        exit;
    }
}
