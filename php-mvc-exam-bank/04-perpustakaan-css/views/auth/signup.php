<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup - Perpustakaan Sederhana</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="login-wrap">
  <div class="card login-card">
    <h1 class="text-tengah">Daftar Akun</h1>
    <p class="sub text-tengah">Buat akun baru untuk mulai menggunakan aplikasi</p>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <label>Nama</label>
      <input type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
      <label>Email</label>
      <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      <label>Password</label>
      <input type="password" name="password" required minlength="6">
      <button class="btn btn-primary" style="width:100%; margin-top:16px;">Daftar</button>
    </form>
    <p class="sub text-tengah" style="margin-top:16px; margin-bottom:0;">Sudah punya akun? <a href="index.php?page=login">Login di sini</a></p>
  </div>
</div>
</body>
</html>
