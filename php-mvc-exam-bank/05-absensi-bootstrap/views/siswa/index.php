<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Siswa</h4>
  <a href="index.php?page=siswa-form" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>No</th><th>Nama</th><th>Kelas</th><th style="width:170px;">Aksi</th></tr></thead>
      <tbody>
        <?php if (count($siswa) === 0): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada siswa</td></tr>
        <?php endif; ?>
        <?php foreach ($siswa as $i => $s): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($s['nama']) ?></td>
            <td><?= htmlspecialchars($s['nama_kelas']) ?></td>
            <td>
              <a href="index.php?page=siswa-form&id=<?= $s['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=siswa-hapus&id=<?= $s['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
