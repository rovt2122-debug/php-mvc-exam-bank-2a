<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $layanan ? 'Edit Layanan' : 'Tambah Layanan' ?></h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=layanan-simpan">
    <input type="hidden" name="id" value="<?= $layanan['id'] ?? '' ?>">
    <label>Nama Layanan</label>
    <input type="text" name="nama" required value="<?= htmlspecialchars($layanan['nama'] ?? '') ?>">
    <label>Harga per Kg</label>
    <input type="number" name="harga_per_kg" required min="1" value="<?= $layanan['harga_per_kg'] ?? '' ?>">
    <label>Biaya Tambahan</label>
    <input type="number" name="biaya_tambahan" min="0" value="<?= $layanan['biaya_tambahan'] ?? 0 ?>">
    <p class="sub" style="margin-top:8px;">Contoh: layanan express biasanya punya biaya tambahan.</p>
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=layanan" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
