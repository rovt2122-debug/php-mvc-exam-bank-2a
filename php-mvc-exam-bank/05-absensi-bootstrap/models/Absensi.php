<?php

class Absensi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all($tanggal)
    {
        $stmt = $this->pdo->prepare(
            "SELECT a.*, s.nama AS nama_siswa, k.nama AS nama_kelas
             FROM absensi a
             JOIN siswa s ON s.id = a.siswa_id
             JOIN kelas k ON k.id = s.kelas_id
             WHERE a.tanggal = ?
             ORDER BY k.nama, s.nama");
        $stmt->execute([$tanggal]);
        return $stmt->fetchAll();
    }

    // rekap jumlah hadir/izin/sakit/alpa pada satu tanggal
    public function rekap($tanggal)
    {
        $stmt = $this->pdo->prepare(
            "SELECT status, COUNT(*) AS jumlah FROM absensi
             WHERE tanggal = ? GROUP BY status");
        $stmt->execute([$tanggal]);

        $rekap = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $rekap[$row['status']] = (int)$row['jumlah'];
        }
        return $rekap;
    }

    // cek biar satu siswa tidak punya absensi ganda di tanggal yang sama
    public function exists($siswaId, $tanggal)
    {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM absensi WHERE siswa_id = ? AND tanggal = ?");
        $stmt->execute([$siswaId, $tanggal]);
        return $stmt->fetch() !== false;
    }

    public function create($siswaId, $tanggal, $status, $jamMasuk)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO absensi (siswa_id, tanggal, status, jam_masuk, created_at)
             VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$siswaId, $tanggal, $status, $jamMasuk]);
    }
}
