<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $produk ? 'Edit Produk' : 'Tambah Produk' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=produk-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $produk['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($produk['nama'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="harga" class="form-control" required min="1"
          value="<?= $produk['harga'] ?? '' ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=produk" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
