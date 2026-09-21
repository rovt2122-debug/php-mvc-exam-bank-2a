<?php

class Layanan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM layanan ORDER BY nama")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM layanan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $hargaPerKg, $biayaTambahan)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO layanan (nama, harga_per_kg, biaya_tambahan) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $hargaPerKg, $biayaTambahan]);
    }

    public function update($id, $nama, $hargaPerKg, $biayaTambahan)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE layanan SET nama = ?, harga_per_kg = ?, biaya_tambahan = ? WHERE id = ?");
        return $stmt->execute([$nama, $hargaPerKg, $biayaTambahan, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM layanan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
