<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Daftar Absensi</h4>
  <a href="index.php?page=absensi-form" class="btn btn-primary btn-sm">+ Input Absensi</a>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body py-2">
    <form method="get" action="index.php" class="row g-2 align-items-center">
      <input type="hidden" name="page" value="absensi">
      <div class="col-auto">
        <label class="form-label mb-0">Filter Tanggal</label>
      </div>
      <div class="col-auto">
        <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= $tanggal ?>">
      </div>
      <div class="col-auto">
        <button class="btn btn-sm btn-outline-primary">Tampilkan</button>
      </div>
    </form>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-3 col-6"><div class="card shadow-sm text-center"><div class="card-body py-2">
    <div class="small text-muted">Hadir</div><div class="fs-4 fw-bold"><?= $rekap['hadir'] ?></div>
  </div></div></div>
  <div class="col-md-3 col-6"><div class="card shadow-sm text-center"><div class="card-body py-2">
    <div class="small text-muted">Izin</div><div class="fs-4 fw-bold"><?= $rekap['izin'] ?></div>
  </div></div></div>
  <div class="col-md-3 col-6"><div class="card shadow-sm text-center"><div class="card-body py-2">
    <div class="small text-muted">Sakit</div><div class="fs-4 fw-bold"><?= $rekap['sakit'] ?></div>
  </div></div></div>
  <div class="col-md-3 col-6"><div class="card shadow-sm text-center"><div class="card-body py-2">
    <div class="small text-muted">Alpa</div><div class="fs-4 fw-bold"><?= $rekap['alpa'] ?></div>
  </div></div></div>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Tanggal</th><th>Jam Masuk</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php if (count($absensi) === 0): ?>
          <tr><td colspan="7" class="text-center text-muted py-4">Belum ada absensi pada tanggal ini</td></tr>
        <?php endif; ?>
        <?php foreach ($absensi as $i => $a): ?>
          <tr>
            <td><?= ($halaman - 1) * $perPage + $i + 1 ?></td>
            <td><?= htmlspecialchars($a['nama_siswa']) ?></td>
            <td><?= htmlspecialchars($a['nama_kelas']) ?></td>
            <td><?= $a['tanggal'] ?></td>
            <td><?= $a['jam_masuk'] ?: '-' ?></td>
            <td>
              <?php
              $badge = ['hadir' => 'text-bg-success', 'izin' => 'text-bg-info',
                        'sakit' => 'text-bg-warning', 'alpa' => 'text-bg-danger'];
              ?>
              <span class="badge <?= $badge[$a['status']] ?>"><?= $a['status'] ?></span>
            </td>
            <td style="white-space: nowrap;">
              <a href="index.php?page=absensi-edit&id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=absensi-hapus&id=<?= $a['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if ($totalHalaman > 1): ?>
<nav class="mt-3">
  <ul class="pagination pagination-sm justify-content-center mb-0">
    <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
      <li class="page-item <?= $i === $halaman ? 'active' : '' ?>">
        <a class="page-link" href="index.php?page=absensi&tanggal=<?= urlencode($tanggal) ?>&halaman=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
