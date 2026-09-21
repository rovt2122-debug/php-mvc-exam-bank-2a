<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $kategori ? 'Edit Kategori' : 'Tambah Kategori' ?></h1>

<div class="card" style="max-width:420px;">
  <form method="post" action="index.php?page=kategori-simpan">
    <input type="hidden" name="id" value="<?= $kategori['id'] ?? '' ?>">
    <label>Nama Kategori</label>
    <input type="text" name="nama" required value="<?= htmlspecialchars($kategori['nama'] ?? '') ?>">
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=kategori" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
