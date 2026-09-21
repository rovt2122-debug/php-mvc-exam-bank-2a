<?php

class RiwayatStok
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT r.*, b.nama AS nama_barang FROM riwayat_stok r
                JOIN barang b ON b.id = r.barang_id
                ORDER BY r.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function countAll()
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM riwayat_stok")->fetchColumn();
    }

    // ambil sebagian riwayat untuk pagination
    public function page($limit, $offset)
    {
        $sql = "SELECT r.*, b.nama AS nama_barang FROM riwayat_stok r
                JOIN barang b ON b.id = r.barang_id
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($barangId, $jenis, $jumlah, $keterangan)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO riwayat_stok (barang_id, jenis, jumlah, keterangan, created_at)
             VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$barangId, $jenis, $jumlah, $keterangan]);
    }
}
