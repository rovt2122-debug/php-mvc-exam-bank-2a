<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Transaksi Rental Baru</h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=transaksi-simpan" style="max-width:520px;">
      <div class="mb-3">
        <label class="form-label">Kendaraan</label>
        <select name="kendaraan_id" class="form-select" required>
          <option value="">- pilih kendaraan -</option>
          <?php foreach ($kendaraan as $k): ?>
            <option value="<?= $k['id'] ?>">
              <?= htmlspecialchars($k['nama']) ?> - Rp<?= number_format($k['harga_per_hari'], 0, ',', '.') ?>/hari
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Pelanggan</label>
        <select name="pelanggan_id" class="form-select" required>
          <option value="">- pilih pelanggan -</option>
          <?php foreach ($pelanggan as $p): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tanggal Mulai</label>
          <input type="datetime-local" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Tanggal Selesai</label>
          <input type="datetime-local" name="tanggal_selesai" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Pembayaran</label>
        <input type="number" name="bayar" class="form-control" min="0" required>
        <div class="form-text">
          Kalau pembayaran kurang dari total, transaksi tercatat sebagai belum lunas.
        </div>
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=transaksi" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
