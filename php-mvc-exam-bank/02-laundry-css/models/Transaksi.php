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
        $sql = "SELECT t.*, p.nama AS nama_pelanggan, l.nama AS nama_layanan
                FROM transaksi t
                JOIN pelanggan p ON p.id = t.pelanggan_id
                JOIN layanan l ON l.id = t.layanan_id
                ORDER BY t.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO transaksi
            (pelanggan_id, layanan_id, berat, harga_per_kg, biaya_tambahan, total, status, tanggal_masuk, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'diproses', ?, NOW())");
        return $stmt->execute([
            $data['pelanggan_id'], $data['layanan_id'], $data['berat'],
            $data['harga_per_kg'], $data['biaya_tambahan'], $data['total'], $data['tanggal_masuk'],
        ]);
    }

    public function updateStatus($id, $status)
    {
        // tanggal_selesai dicatat saat status berubah jadi selesai
        if ($status === 'selesai') {
            $stmt = $this->pdo->prepare(
                "UPDATE transaksi SET status = ?, tanggal_selesai = CURDATE() WHERE id = ?");
            return $stmt->execute([$status, $id]);
        }

        $stmt = $this->pdo->prepare("UPDATE transaksi SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
