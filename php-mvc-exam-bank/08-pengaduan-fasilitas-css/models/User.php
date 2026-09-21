<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($nama, $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $email, $password]);
    }
}
