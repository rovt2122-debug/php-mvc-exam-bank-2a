<?php

class Produk
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM produk ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $harga)
    {
        $stmt = $this->pdo->prepare("INSERT INTO produk (nama, harga) VALUES (?, ?)");
        return $stmt->execute([$nama, $harga]);
    }

    public function update($id, $nama, $harga)
    {
        $stmt = $this->pdo->prepare("UPDATE produk SET nama = ?, harga = ? WHERE id = ?");
        return $stmt->execute([$nama, $harga, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM produk WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
