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
        // riwayat transaksi beserta nama kasir dan jumlah itemnya
        $sql = "SELECT t.*, u.nama AS kasir,
                (SELECT COALESCE(SUM(qty), 0) FROM transaksi_detail d WHERE d.transaksi_id = t.id) AS jumlah_item
                FROM transaksi t JOIN users u ON u.id = t.user_id
                ORDER BY t.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.*, u.nama AS kasir FROM transaksi t
             JOIN users u ON u.id = t.user_id WHERE t.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function details($transaksiId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT d.*, p.nama AS nama_produk
             FROM transaksi_detail d JOIN produk p ON p.id = d.produk_id
             WHERE d.transaksi_id = ?");
        $stmt->execute([$transaksiId]);
        return $stmt->fetchAll();
    }

    // simpan transaksi beserta detailnya dalam satu database transaction
    public function simpan($userId, $items, $bayar)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        if ($bayar < $total) {
            return false;
        }

        $this->pdo->beginTransaction();

        try {
            // created_at pakai NOW() supaya waktunya dari server
            $stmt = $this->pdo->prepare(
                "INSERT INTO transaksi (user_id, total, bayar, kembalian, created_at)
                 VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$userId, $total, $bayar, $bayar - $total]);
            $transaksiId = $this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare(
                "INSERT INTO transaksi_detail (transaksi_id, produk_id, harga, qty, diskon, subtotal)
                 VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmt->execute([
                    $transaksiId, $item['produk_id'], $item['harga'],
                    $item['qty'], $item['diskon'], $item['subtotal'],
                ]);
            }

            $this->pdo->commit();
            return $transaksiId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
