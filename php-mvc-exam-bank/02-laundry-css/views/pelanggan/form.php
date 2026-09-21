<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $pelanggan ? 'Edit Pelanggan' : 'Tambah Pelanggan' ?></h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=pelanggan-simpan">
    <input type="hidden" name="id" value="<?= $pelanggan['id'] ?? '' ?>">
    <label>Nama</label>
    <input type="text" name="nama" required value="<?= htmlspecialchars($pelanggan['nama'] ?? '') ?>">
    <label>Telepon</label>
    <input type="text" name="telepon" value="<?= htmlspecialchars($pelanggan['telepon'] ?? '') ?>">
    <label>Alamat</label>
    <textarea name="alamat" rows="2"><?= htmlspecialchars($pelanggan['alamat'] ?? '') ?></textarea>
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=pelanggan" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
