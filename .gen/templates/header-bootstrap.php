<?php $userNama = $_SESSION['user_nama'] ?? ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{APP_NAME}}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">{{APP_NAME}}</a>
    <ul class="navbar-nav me-auto">
      {{NAV_LINKS}}
    </ul>
    <span class="navbar-text me-3 d-none d-md-inline"><?= htmlspecialchars($userNama) ?></span>
    <a href="index.php?page=logout" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>
<main class="container pb-5">
