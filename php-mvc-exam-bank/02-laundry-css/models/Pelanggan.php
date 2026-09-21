<?php

class Pelanggan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM pelanggan ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pelanggan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $telepon, $alamat)
    {
        $stmt = $this->pdo->prepare("INSERT INTO pelanggan (nama, telepon, alamat) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $telepon, $alamat]);
    }

    public function update($id, $nama, $telepon, $alamat)
    {
        $stmt = $this->pdo->prepare("UPDATE pelanggan SET nama = ?, telepon = ?, alamat = ? WHERE id = ?");
        return $stmt->execute([$nama, $telepon, $alamat, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pelanggan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
