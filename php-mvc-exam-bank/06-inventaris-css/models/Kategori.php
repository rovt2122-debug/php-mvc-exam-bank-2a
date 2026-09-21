<?php

class Kategori
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM kategori ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kategori WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama)
    {
        $stmt = $this->pdo->prepare("INSERT INTO kategori (nama) VALUES (?)");
        return $stmt->execute([$nama]);
    }

    public function update($id, $nama)
    {
        $stmt = $this->pdo->prepare("UPDATE kategori SET nama = ? WHERE id = ?");
        return $stmt->execute([$nama, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM kategori WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
