<?php

class Transaksi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT t.*, k.nama AS nama_kendaraan, p.nama AS nama_pelanggan
                FROM transaksi t
                JOIN kendaraan k ON k.id = t.kendaraan_id
                JOIN pelanggan p ON p.id = t.pelanggan_id
                ORDER BY t.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO transaksi
            (kendaraan_id, pelanggan_id, tanggal_mulai, tanggal_selesai,
             harga_per_hari, jumlah_hari, total, bayar, kembalian, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['kendaraan_id'], $data['pelanggan_id'],
            $data['tanggal_mulai'], $data['tanggal_selesai'],
            $data['harga_per_hari'], $data['jumlah_hari'], $data['total'],
            $data['bayar'], $data['kembalian'], $data['status'],
        ]);
    }
}
