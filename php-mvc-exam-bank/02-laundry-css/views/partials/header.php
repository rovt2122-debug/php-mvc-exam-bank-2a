<?php $userNama = $_SESSION['user_nama'] ?? ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laundry Sederhana</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar">
  <a class="brand" href="index.php">Laundry Sederhana</a>
  <div class="menu">
    <a href="index.php?page=pelanggan">Pelanggan</a><a href="index.php?page=layanan">Layanan</a><a href="index.php?page=transaksi">Transaksi</a>
  </div>
  <span class="user"><?= htmlspecialchars($userNama) ?></span>
  <a href="index.php?page=logout" class="btn-logout">Logout</a>
</nav>
<main class="container">
