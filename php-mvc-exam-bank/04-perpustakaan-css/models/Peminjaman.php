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

    public function countAll()
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM peminjaman")->fetchColumn();
    }

    // ambil sebagian peminjaman untuk pagination
    public function page($limit, $offset)
    {
        $sql = "SELECT p.*, b.judul, a.nama AS nama_anggota
                FROM peminjaman p
                JOIN buku b ON b.id = p.buku_id
                JOIN anggota a ON a.id = p.anggota_id
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // update tanggal pinjam/jatuh tempo dan denda (misal denda sudah dibayar sebagian)
    public function update($id, $tanggalPinjam, $tanggalKembali, $denda)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE peminjaman
             SET tanggal_pinjam = ?, tanggal_kembali = ?, denda = ?
             WHERE id = ?");
        return $stmt->execute([$tanggalPinjam, $tanggalKembali, $denda, $id]);
    }

    public function hapus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM peminjaman WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM peminjaman WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // detail peminjaman beserta judul buku dan nama anggota, dipakai di form edit
    public function findDetail($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, b.judul, a.nama AS nama_anggota
             FROM peminjaman p
             JOIN buku b ON b.id = p.buku_id
             JOIN anggota a ON a.id = p.anggota_id
             WHERE p.id = ?");
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
