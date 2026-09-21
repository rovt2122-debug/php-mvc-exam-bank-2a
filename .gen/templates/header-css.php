<?php $userNama = $_SESSION['user_nama'] ?? ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{APP_NAME}}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar">
  <a class="brand" href="index.php">{{APP_NAME}}</a>
  <div class="menu">
    {{NAV_LINKS}}
  </div>
  <span class="user"><?= htmlspecialchars($userNama) ?></span>
  <a href="index.php?page=logout" class="btn-logout">Logout</a>
</nav>
<main class="container">
