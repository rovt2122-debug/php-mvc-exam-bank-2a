<?php

class Lapangan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM lapangan ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM lapangan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $jenis)
    {
        $stmt = $this->pdo->prepare("INSERT INTO lapangan (nama, jenis) VALUES (?, ?)");
        return $stmt->execute([$nama, $jenis]);
    }

    public function update($id, $nama, $jenis)
    {
        $stmt = $this->pdo->prepare("UPDATE lapangan SET nama = ?, jenis = ? WHERE id = ?");
        return $stmt->execute([$nama, $jenis, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM lapangan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
