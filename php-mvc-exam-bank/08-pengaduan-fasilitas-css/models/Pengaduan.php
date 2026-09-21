<?php

class Pengaduan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // kalau userId diisi, cuma ambil pengaduan milik user itu
    public function all($userId = null)
    {
        $sql = "SELECT p.*, k.nama AS nama_kategori, u.nama AS nama_pelapor
                FROM pengaduan p
                JOIN kategori k ON k.id = p.kategori_id
                JOIN users u ON u.id = p.user_id";
        $params = [];

        if ($userId !== null) {
            $sql .= " WHERE p.user_id = ?";
            $params[] = $userId;
        }

        $sql .= " ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // hitung jumlah pengaduan, opsional filter per user
    public function countAll($userId = null)
    {
        if ($userId !== null) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengaduan WHERE user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM pengaduan");
        }
        return (int)$stmt->fetchColumn();
    }

    // ambil sebagian pengaduan untuk pagination
    public function page($userId, $limit, $offset)
    {
        $sql = "SELECT p.*, k.nama AS nama_kategori, u.nama AS nama_pelapor
                FROM pengaduan p
                JOIN kategori k ON k.id = p.kategori_id
                JOIN users u ON u.id = p.user_id";
        $params = [];

        if ($userId !== null) {
            $sql .= " WHERE p.user_id = ?";
            $params[] = $userId;
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
        $params[] = (int)$limit;
        $params[] = (int)$offset;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pengaduan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($userId, $kategoriId, $judul, $deskripsi, $lokasi)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO pengaduan (user_id, kategori_id, judul, deskripsi, lokasi, status, created_at)
             VALUES (?, ?, ?, ?, ?, 'diajukan', NOW())");
        return $stmt->execute([$userId, $kategoriId, $judul, $deskripsi, $lokasi]);
    }

    public function update($id, $kategoriId, $judul, $deskripsi, $lokasi)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE pengaduan SET kategori_id = ?, judul = ?, deskripsi = ?, lokasi = ? WHERE id = ?");
        return $stmt->execute([$kategoriId, $judul, $deskripsi, $lokasi, $id]);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE pengaduan SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pengaduan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
