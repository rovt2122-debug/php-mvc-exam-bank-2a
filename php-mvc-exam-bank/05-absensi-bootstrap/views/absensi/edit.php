<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Edit Absensi</h4>

<div class="card shadow-sm" style="max-width:520px;">
  <div class="card-body">
    <p class="text-muted mb-2">
      <?= htmlspecialchars($absensi['nama_siswa']) ?> -
      <?= htmlspecialchars($absensi['nama_kelas']) ?> -
      <?= $absensi['tanggal'] ?>
    </p>
    <form method="post" action="index.php?page=absensi-update">
      <input type="hidden" name="id" value="<?= $absensi['id'] ?>">

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <?php foreach (['hadir', 'izin', 'sakit', 'alpa'] as $s): ?>
            <option value="<?= $s ?>" <?= $absensi['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control" value="<?= $absensi['jam_masuk'] ?>">
        <div class="form-text">Kosongkan kalau statusnya bukan hadir.</div>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=absensi&tanggal=<?= $absensi['tanggal'] ?>" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
