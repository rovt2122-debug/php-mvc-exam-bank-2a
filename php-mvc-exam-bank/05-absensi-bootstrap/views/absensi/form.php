<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Input Absensi</h4>

<div class="card shadow-sm mb-3">
  <div class="card-body py-2">
    <form method="get" action="index.php" class="row g-2 align-items-center">
      <input type="hidden" name="page" value="absensi-form">
      <div class="col-auto">
        <label class="form-label mb-0">Kelas</label>
      </div>
      <div class="col-auto">
        <select name="kelas_id" class="form-select form-select-sm" required>
          <option value="">- pilih kelas -</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= $kelasId == $k['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($k['nama']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <label class="form-label mb-0">Tanggal</label>
      </div>
      <div class="col-auto">
        <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= $tanggal ?>">
      </div>
      <div class="col-auto">
        <button class="btn btn-sm btn-outline-primary">Tampilkan Siswa</button>
      </div>
    </form>
  </div>
</div>

<?php if ($kelasId > 0): ?>
  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (count($siswa) === 0): ?>
        <p class="text-center text-muted py-3 mb-0">Tidak ada siswa di kelas ini</p>
      <?php else: ?>
        <form method="post" action="index.php?page=absensi-simpan">
          <input type="hidden" name="kelas_id" value="<?= $kelasId ?>">
          <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>Nama Siswa</th><th style="width:160px;">Status</th><th style="width:160px;">Jam Masuk</th></tr></thead>
              <tbody>
                <?php foreach ($siswa as $s): ?>
                  <tr>
                    <td><?= htmlspecialchars($s['nama']) ?></td>
                    <td>
                      <select name="status[<?= $s['id'] ?>]" class="form-select form-select-sm">
                        <option value="hadir">hadir</option>
                        <option value="izin">izin</option>
                        <option value="sakit">sakit</option>
                        <option value="alpa">alpa</option>
                      </select>
                    </td>
                    <td><input type="time" name="jam_masuk[<?= $s['id'] ?>]" class="form-control form-control-sm"></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button class="btn btn-primary">Simpan Absensi</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
