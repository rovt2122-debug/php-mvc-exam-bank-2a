<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $buku ? 'Edit Buku' : 'Tambah Buku' ?></h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=buku-simpan">
    <input type="hidden" name="id" value="<?= $buku['id'] ?? '' ?>">
    <label>Judul</label>
    <input type="text" name="judul" required value="<?= htmlspecialchars($buku['judul'] ?? '') ?>">
    <label>Pengarang</label>
    <input type="text" name="pengarang" value="<?= htmlspecialchars($buku['pengarang'] ?? '') ?>">
    <label>Tahun</label>
    <input type="number" name="tahun" min="1900" max="2100" value="<?= $buku['tahun'] ?? date('Y') ?>">
    <label>Stok</label>
    <input type="number" name="stok" required min="0" value="<?= $buku['stok'] ?? 1 ?>">
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=buku" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
