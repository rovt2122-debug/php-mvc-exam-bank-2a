<?php

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nama'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'] ?? 'user';
                header('Location: index.php');
                exit;
            }
            $error = 'Email atau password salah';
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    public function signup()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($nama === '' || $email === '' || $password === '') {
                $error = 'Semua field wajib diisi';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email sudah terdaftar';
            } else {
                // password disimpan dalam bentuk hash, bukan teks asli
                $this->userModel->create($nama, $email, password_hash($password, PASSWORD_DEFAULT));
                $_SESSION['flash_sukses'] = 'Signup berhasil, silakan login';
                header('Location: index.php?page=login');
                exit;
            }
        }
        include __DIR__ . '/../views/auth/signup.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
