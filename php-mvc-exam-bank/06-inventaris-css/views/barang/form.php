<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $barang ? 'Edit Barang' : 'Tambah Barang' ?></h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=barang-simpan">
    <input type="hidden" name="id" value="<?= $barang['id'] ?? '' ?>">
    <label>Nama Barang</label>
    <input type="text" name="nama" required value="<?= htmlspecialchars($barang['nama'] ?? '') ?>">
    <label>Kategori</label>
    <select name="kategori_id" required>
      <option value="">- pilih kategori -</option>
      <?php foreach ($kategori as $k): ?>
        <option value="<?= $k['id'] ?>" <?= ($barang['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($k['nama']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <label>Stok</label>
    <input type="number" name="stok" required min="0" value="<?= $barang['stok'] ?? 0 ?>">
    <label>Lokasi</label>
    <input type="text" name="lokasi" value="<?= htmlspecialchars($barang['lokasi'] ?? '') ?>">
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=barang" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
