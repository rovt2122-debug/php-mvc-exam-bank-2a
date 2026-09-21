<?php

class Kelas
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM kelas ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kelas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama)
    {
        $stmt = $this->pdo->prepare("INSERT INTO kelas (nama) VALUES (?)");
        return $stmt->execute([$nama]);
    }

    public function update($id, $nama)
    {
        $stmt = $this->pdo->prepare("UPDATE kelas SET nama = ? WHERE id = ?");
        return $stmt->execute([$nama, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM kelas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
