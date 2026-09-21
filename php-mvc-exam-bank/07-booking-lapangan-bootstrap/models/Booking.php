<?php

class Booking
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT b.*, l.nama AS nama_lapangan FROM booking b
                JOIN lapangan l ON l.id = b.lapangan_id
                ORDER BY b.tanggal DESC, b.jam_mulai DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function countAll()
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM booking")->fetchColumn();
    }

    // ambil sebagian booking untuk pagination
    public function page($limit, $offset)
    {
        $sql = "SELECT b.*, l.nama AS nama_lapangan FROM booking b
                JOIN lapangan l ON l.id = b.lapangan_id
                ORDER BY b.tanggal DESC, b.jam_mulai DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function hapus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM booking WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM booking WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO booking
            (lapangan_id, jadwal_id, tanggal, jam_mulai, jam_selesai, durasi, total, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif', NOW())");
        return $stmt->execute([
            $data['lapangan_id'], $data['jadwal_id'], $data['tanggal'],
            $data['jam_mulai'], $data['jam_selesai'], $data['durasi'], $data['total'],
        ]);
    }

    public function batal($id)
    {
        $stmt = $this->pdo->prepare("UPDATE booking SET status = 'batal' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // cek apakah ada booking lain yang waktunya beririsan
    public function cekBentrok($lapanganId, $tanggal, $jamMulai, $jamSelesai)
    {
        // dua rentang beririsan kalau rentang lama mulai sebelum rentang baru selesai
        // dan rentang lama selesai setelah rentang baru mulai
        $stmt = $this->pdo->prepare(
            "SELECT id FROM booking
             WHERE lapangan_id = ? AND tanggal = ? AND status != 'batal'
             AND jam_mulai < ? AND jam_selesai > ?");
        $stmt->execute([$lapanganId, $tanggal, $jamSelesai, $jamMulai]);
        return $stmt->fetch();
    }
}
