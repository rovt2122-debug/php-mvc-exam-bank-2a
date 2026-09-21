<?php

class Barang
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $sql = "SELECT b.*, k.nama AS nama_kategori FROM barang b
                JOIN kategori k ON k.id = b.kategori_id ORDER BY b.nama";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nama, $kategoriId, $stok, $lokasi)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO barang (nama, kategori_id, stok, lokasi) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nama, $kategoriId, $stok, $lokasi]);
    }

    public function update($id, $nama, $kategoriId, $stok, $lokasi)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE barang SET nama = ?, kategori_id = ?, stok = ?, lokasi = ? WHERE id = ?");
        return $stmt->execute([$nama, $kategoriId, $stok, $lokasi, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM barang WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function tambahStok($id, $jumlah)
    {
        $stmt = $this->pdo->prepare("UPDATE barang SET stok = stok + ? WHERE id = ?");
        return $stmt->execute([$jumlah, $id]);
    }

    public function kurangiStok($id, $jumlah)
    {
        $stmt = $this->pdo->prepare("UPDATE barang SET stok = stok - ? WHERE id = ?");
        return $stmt->execute([$jumlah, $id]);
    }
}
