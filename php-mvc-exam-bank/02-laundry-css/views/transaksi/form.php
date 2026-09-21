<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Transaksi Laundry Baru</h1>

<div class="card" style="max-width:520px;">
  <form method="post" action="index.php?page=transaksi-simpan">
    <label>Pelanggan</label>
    <select name="pelanggan_id" required>
      <option value="">- pilih pelanggan -</option>
      <?php foreach ($pelanggan as $p): ?>
        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Layanan</label>
    <select name="layanan_id" required>
      <option value="">- pilih layanan -</option>
      <?php foreach ($layanan as $l): ?>
        <option value="<?= $l['id'] ?>">
          <?= htmlspecialchars($l['nama']) ?> - Rp<?= number_format($l['harga_per_kg'], 0, ',', '.') ?>/kg
          <?= $l['biaya_tambahan'] > 0 ? ' (+ Rp' . number_format($l['biaya_tambahan'], 0, ',', '.') . ')' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Berat Cucian (kg)</label>
    <input type="number" name="berat" step="0.1" min="0.1" required>

    <label>Tanggal Masuk</label>
    <input type="date" name="tanggal_masuk" value="<?= date('Y-m-d') ?>" required>

    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=transaksi" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
