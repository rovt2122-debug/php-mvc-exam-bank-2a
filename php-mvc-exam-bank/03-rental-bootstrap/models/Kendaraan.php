<?php

class Kendaraan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM kendaraan ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $plat, $hargaPerHari)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO kendaraan (nama, plat, harga_per_hari) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $plat, $hargaPerHari]);
    }

    public function update($id, $nama, $plat, $hargaPerHari)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE kendaraan SET nama = ?, plat = ?, harga_per_hari = ? WHERE id = ?");
        return $stmt->execute([$nama, $plat, $hargaPerHari, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM kendaraan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
