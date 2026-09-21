<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Kelas</h4>
  <a href="index.php?page=kelas-form" class="btn btn-primary btn-sm">+ Tambah Kelas</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>No</th><th>Nama Kelas</th><th style="width:170px;">Aksi</th></tr></thead>
      <tbody>
        <?php if (count($kelas) === 0): ?>
          <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kelas</td></tr>
        <?php endif; ?>
        <?php foreach ($kelas as $i => $k): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($k['nama']) ?></td>
            <td>
              <a href="index.php?page=kelas-form&id=<?= $k['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=kelas-hapus&id=<?= $k['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
