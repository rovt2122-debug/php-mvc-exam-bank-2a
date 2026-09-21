<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $pelanggan ? 'Edit Pelanggan' : 'Tambah Pelanggan' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=pelanggan-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $pelanggan['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($pelanggan['nama'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="form-control"
          value="<?= htmlspecialchars($pelanggan['telepon'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($pelanggan['alamat'] ?? '') ?></textarea>
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=pelanggan" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
