<?php

class Jadwal
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT j.*, l.nama AS nama_lapangan FROM jadwal j
                JOIN lapangan l ON l.id = j.lapangan_id
                ORDER BY l.nama, j.jam_mulai";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM jadwal WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($lapanganId, $jamMulai, $jamSelesai, $hargaPerJam)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO jadwal (lapangan_id, jam_mulai, jam_selesai, harga_per_jam)
             VALUES (?, ?, ?, ?)");
        return $stmt->execute([$lapanganId, $jamMulai, $jamSelesai, $hargaPerJam]);
    }

    public function update($id, $lapanganId, $jamMulai, $jamSelesai, $hargaPerJam)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE jadwal SET lapangan_id = ?, jam_mulai = ?, jam_selesai = ?, harga_per_jam = ?
             WHERE id = ?");
        return $stmt->execute([$lapanganId, $jamMulai, $jamSelesai, $hargaPerJam, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM jadwal WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
