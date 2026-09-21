<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Booking Lapangan</h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=booking-simpan" style="max-width:520px;">
      <div class="mb-3">
        <label class="form-label">Lapangan</label>
        <select name="lapangan_id" class="form-select" required>
          <option value="">- pilih lapangan -</option>
          <?php foreach ($lapangan as $l): ?>
            <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Jadwal (menentukan harga per jam)</label>
        <select name="jadwal_id" class="form-select" required>
          <option value="">- pilih jadwal -</option>
          <?php foreach ($jadwal as $j): ?>
            <option value="<?= $j['id'] ?>">
              <?= htmlspecialchars($j['nama_lapangan']) ?> -
              <?= substr($j['jam_mulai'], 0, 5) ?> s/d <?= substr($j['jam_selesai'], 0, 5) ?> -
              Rp<?= number_format($j['harga_per_jam'], 0, ',', '.') ?>/jam
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal Booking</label>
        <input type="date" name="tanggal" class="form-control" required>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Jam Mulai</label>
          <input type="time" name="jam_mulai" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Jam Selesai</label>
          <input type="time" name="jam_selesai" class="form-control" required>
        </div>
      </div>
      <div class="alert alert-info py-2 small">
        Total = durasi jam x harga per jam. Lapangan tidak bisa dibooking kalau waktunya bentrok dengan booking lain.
      </div>
      <button class="btn btn-primary">Simpan Booking</button>
      <a href="index.php?page=booking" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
