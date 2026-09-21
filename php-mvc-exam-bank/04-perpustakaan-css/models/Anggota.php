<?php

class Anggota
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM anggota ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM anggota WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $nomor, $telepon)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO anggota (nama, nomor_anggota, telepon) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $nomor, $telepon]);
    }

    public function update($id, $nama, $nomor, $telepon)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE anggota SET nama = ?, nomor_anggota = ?, telepon = ? WHERE id = ?");
        return $stmt->execute([$nama, $nomor, $telepon, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM anggota WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
