<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - {{APP_NAME}}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="login-wrap">
  <div class="card login-card">
    <h1 class="text-tengah">{{APP_NAME}}</h1>
    <p class="sub text-tengah">Masuk untuk melanjutkan</p>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <label>Email</label>
      <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      <label>Password</label>
      <input type="password" name="password" required>
      <button class="btn btn-primary" style="width:100%; margin-top:16px;">Login</button>
    </form>
    <p class="sub text-tengah" style="margin-top:16px; margin-bottom:0;">Belum punya akun? <a href="index.php?page=signup">Daftar di sini</a></p>
  </div>
</div>

<?php if (isset($_SESSION['flash_sukses'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({ icon: 'success', title: '<?= htmlspecialchars($_SESSION['flash_sukses']) ?>', timer: 2200, showConfirmButton: false });
</script>
<?php unset($_SESSION['flash_sukses']); endif; ?>
</body>
</html>
