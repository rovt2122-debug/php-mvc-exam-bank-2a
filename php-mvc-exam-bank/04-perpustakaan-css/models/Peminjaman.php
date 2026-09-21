<?php

class Peminjaman
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT p.*, b.judul, a.nama AS nama_anggota
                FROM peminjaman p
                JOIN buku b ON b.id = p.buku_id
                JOIN anggota a ON a.id = p.anggota_id
                ORDER BY p.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM peminjaman WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($bukuId, $anggotaId, $tanggalPinjam, $tanggalKembali)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pinjam, tanggal_kembali, status, created_at)
             VALUES (?, ?, ?, ?, 'dipinjam', NOW())");
        return $stmt->execute([$bukuId, $anggotaId, $tanggalPinjam, $tanggalKembali]);
    }

    public function kembalikan($id, $denda)
    {
        // tanggal_dikembalikan diisi tanggal hari ini
        $stmt = $this->pdo->prepare(
            "UPDATE peminjaman
             SET status = 'kembali', tanggal_dikembalikan = CURDATE(), denda = ?
             WHERE id = ?");
        return $stmt->execute([$denda, $id]);
    }
}
