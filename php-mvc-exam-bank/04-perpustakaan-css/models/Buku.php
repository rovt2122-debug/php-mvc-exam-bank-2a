<?php

class Buku
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM buku ORDER BY judul")->fetchAll();
    }

    // buku yang stoknya masih ada, dipakai di form peminjaman
    public function allTersedia()
    {
        return $this->pdo->query("SELECT * FROM buku WHERE stok > 0 ORDER BY judul")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM buku WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($judul, $pengarang, $tahun, $stok)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO buku (judul, pengarang, tahun, stok) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$judul, $pengarang, $tahun, $stok]);
    }

    public function update($id, $judul, $pengarang, $tahun, $stok)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE buku SET judul = ?, pengarang = ?, tahun = ?, stok = ? WHERE id = ?");
        return $stmt->execute([$judul, $pengarang, $tahun, $stok, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM buku WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function kurangiStok($id)
    {
        $stmt = $this->pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function tambahStok($id)
    {
        $stmt = $this->pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
