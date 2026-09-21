<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Lapangan</h4>
  <a href="index.php?page=lapangan-form" class="btn btn-primary btn-sm">+ Tambah Lapangan</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>No</th><th>Nama</th><th>Jenis</th><th style="width:170px;">Aksi</th></tr></thead>
      <tbody>
        <?php if (count($lapangan) === 0): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada lapangan</td></tr>
        <?php endif; ?>
        <?php foreach ($lapangan as $i => $l): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($l['nama']) ?></td>
            <td><?= htmlspecialchars($l['jenis']) ?></td>
            <td>
              <a href="index.php?page=lapangan-form&id=<?= $l['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=lapangan-hapus&id=<?= $l['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
