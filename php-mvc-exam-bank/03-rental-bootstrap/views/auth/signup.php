<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup - Rental Kendaraan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-light">
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h4 class="mb-3 text-center">Daftar Akun</h4>
          <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" required
                value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button class="btn btn-primary w-100">Daftar</button>
          </form>
          <p class="mt-3 mb-0 text-center small">Sudah punya akun? <a href="index.php?page=login">Login di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
