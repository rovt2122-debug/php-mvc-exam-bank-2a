<?php

class Siswa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT s.*, k.nama AS nama_kelas FROM siswa s
                JOIN kelas k ON k.id = s.kelas_id ORDER BY s.nama";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function byKelas($kelasId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM siswa WHERE kelas_id = ? ORDER BY nama");
        $stmt->execute([$kelasId]);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $kelasId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO siswa (nama, kelas_id) VALUES (?, ?)");
        return $stmt->execute([$nama, $kelasId]);
    }

    public function update($id, $nama, $kelasId)
    {
        $stmt = $this->pdo->prepare("UPDATE siswa SET nama = ?, kelas_id = ? WHERE id = ?");
        return $stmt->execute([$nama, $kelasId, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM siswa WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
