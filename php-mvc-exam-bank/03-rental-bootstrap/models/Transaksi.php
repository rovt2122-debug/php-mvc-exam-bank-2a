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

    public function countAll()
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
    }

    // ambil sebagian transaksi untuk pagination
    public function page($limit, $offset)
    {
        $sql = "SELECT t.*, k.nama AS nama_kendaraan, p.nama AS nama_pelanggan
                FROM transaksi t
                JOIN kendaraan k ON k.id = t.kendaraan_id
                JOIN pelanggan p ON p.id = t.pelanggan_id
                ORDER BY t.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // tandai transaksi jadi lunas, bayar dianggap sama dengan total
    public function tandaiLunas($id)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE transaksi SET status = 'lunas', bayar = total, kembalian = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function hapus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
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
