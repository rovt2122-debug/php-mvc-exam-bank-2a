<?php

class AbsensiController
{
    private $absensiModel;
    private $kelasModel;
    private $siswaModel;

    public function __construct($pdo)
    {
        $this->absensiModel = new Absensi($pdo);
        $this->kelasModel = new Kelas($pdo);
        $this->siswaModel = new Siswa($pdo);
    }

    public function index()
    {
        $tanggal = $_GET['tanggal'] ?? date('Y-m-d');
        $absensi = $this->absensiModel->all($tanggal);
        $rekap = $this->absensiModel->rekap($tanggal);
        include __DIR__ . '/../views/absensi/index.php';
    }

    public function form()
    {
        $kelas = $this->kelasModel->all();
        $kelasId = (int)($_GET['kelas_id'] ?? 0);
        $tanggal = $_GET['tanggal'] ?? date('Y-m-d');

        // siswa dari kelas yang dipilih, ditampilkan untuk diabsen
        $siswa = $kelasId > 0 ? $this->siswaModel->byKelas($kelasId) : [];
        include __DIR__ . '/../views/absensi/form.php';
    }

    public function simpan()
    {
        $kelasId = (int)($_POST['kelas_id'] ?? 0);
        $tanggal = $_POST['tanggal'] ?? '';
        $statusSiswa = $_POST['status'] ?? [];
        $jamMasuk = $_POST['jam_masuk'] ?? [];

        if ($kelasId <= 0 || $tanggal === '' || empty($statusSiswa)) {
            $_SESSION['flash_error'] = 'Data absensi tidak lengkap';
            header('Location: index.php?page=absensi-form');
            exit;
        }

        $berhasil = 0;
        $dilewati = 0;

        foreach ($statusSiswa as $siswaId => $status) {
            $siswaId = (int)$siswaId;
            $jam = $jamMasuk[$siswaId] ?? null;

            // jam masuk cuma dicatat kalau statusnya hadir
            if ($status !== 'hadir') {
                $jam = null;
            }

            // absensi ganda pada tanggal yang sama dilewati
            if ($this->absensiModel->exists($siswaId, $tanggal)) {
                $dilewati++;
                continue;
            }

            $this->absensiModel->create($siswaId, $tanggal, $status, $jam);
            $berhasil++;
        }

        if ($berhasil > 0) {
            $_SESSION['flash_sukses'] = "Absensi tersimpan untuk {$berhasil} siswa";
            if ($dilewati > 0) {
                $_SESSION['flash_sukses'] .= ", {$dilewati} dilewati karena sudah diabsen";
            }
        } else {
            $_SESSION['flash_error'] = 'Semua siswa sudah diabsen pada tanggal itu';
        }
        header('Location: index.php?page=absensi&tanggal=' . $tanggal);
        exit;
    }
}
