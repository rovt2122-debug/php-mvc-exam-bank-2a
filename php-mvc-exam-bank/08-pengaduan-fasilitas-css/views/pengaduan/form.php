<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $pengaduan ? 'Edit Pengaduan' : 'Buat Pengaduan' ?></h1>

<div class="card" style="max-width:560px;">
  <form method="post" action="index.php?page=pengaduan-simpan">
    <input type="hidden" name="id" value="<?= $pengaduan['id'] ?? '' ?>">
    <label>Judul</label>
    <input type="text" name="judul" required value="<?= htmlspecialchars($pengaduan['judul'] ?? '') ?>">

    <label>Kategori</label>
    <select name="kategori_id" required>
      <option value="">- pilih kategori -</option>
      <?php foreach ($kategori as $k): ?>
        <option value="<?= $k['id'] ?>" <?= ($pengaduan['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($k['nama']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Lokasi</label>
    <input type="text" name="lokasi" placeholder="contoh: toilet lantai 2"
      value="<?= htmlspecialchars($pengaduan['lokasi'] ?? '') ?>">

    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4"><?= htmlspecialchars($pengaduan['deskripsi'] ?? '') ?></textarea>

    <div style="margin-top:16px;">
      <button class="btn btn-primary">Kirim</button>
      <a href="index.php?page=pengaduan" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
