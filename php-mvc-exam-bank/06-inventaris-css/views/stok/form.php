<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Barang Masuk / Keluar</h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=stok-simpan">
    <label>Barang</label>
    <select name="barang_id" required>
      <option value="">- pilih barang -</option>
      <?php foreach ($barang as $b): ?>
        <option value="<?= $b['id'] ?>">
          <?= htmlspecialchars($b['nama']) ?> (stok: <?= $b['stok'] ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <label>Jenis</label>
    <select name="jenis" required>
      <option value="masuk">barang masuk (stok bertambah)</option>
      <option value="keluar">barang keluar (stok berkurang)</option>
    </select>

    <label>Jumlah</label>
    <input type="number" name="jumlah" required min="1">

    <label>Keterangan</label>
    <input type="text" name="keterangan" placeholder="contoh: pembelian baru / dipakai lab">

    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=stok" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
