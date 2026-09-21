<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $siswa ? 'Edit Siswa' : 'Tambah Siswa' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=siswa-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $siswa['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama Siswa</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($siswa['nama'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select" required>
          <option value="">- pilih kelas -</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($siswa['kelas_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($k['nama']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=siswa" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
