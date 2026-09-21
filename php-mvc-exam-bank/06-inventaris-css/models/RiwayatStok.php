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

    public function create($barangId, $jenis, $jumlah, $keterangan)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO riwayat_stok (barang_id, jenis, jumlah, keterangan, created_at)
             VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$barangId, $jenis, $jumlah, $keterangan]);
    }
}
