<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $jadwal ? 'Edit Jadwal' : 'Tambah Jadwal' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=jadwal-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $jadwal['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Lapangan</label>
        <select name="lapangan_id" class="form-select" required>
          <option value="">- pilih lapangan -</option>
          <?php foreach ($lapangan as $l): ?>
            <option value="<?= $l['id'] ?>" <?= ($jadwal['lapangan_id'] ?? '') == $l['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($l['nama']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Jam Mulai</label>
          <input type="time" name="jam_mulai" class="form-control" required
            value="<?= substr($jadwal['jam_mulai'] ?? '', 0, 5) ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Jam Selesai</label>
          <input type="time" name="jam_selesai" class="form-control" required
            value="<?= substr($jadwal['jam_selesai'] ?? '', 0, 5) ?>">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Harga per Jam</label>
        <input type="number" name="harga_per_jam" class="form-control" required min="1"
          value="<?= $jadwal['harga_per_jam'] ?? '' ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=jadwal" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
