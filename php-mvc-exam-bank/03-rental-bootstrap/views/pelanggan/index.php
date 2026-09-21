<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Pelanggan</h4>
  <a href="index.php?page=pelanggan-form" class="btn btn-primary btn-sm">+ Tambah Pelanggan</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th style="width:170px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (count($pelanggan) === 0): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pelanggan</td></tr>
        <?php endif; ?>
        <?php foreach ($pelanggan as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td><?= htmlspecialchars($p['telepon']) ?></td>
            <td><?= htmlspecialchars($p['alamat']) ?></td>
            <td>
              <a href="index.php?page=pelanggan-form&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=pelanggan-hapus&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
