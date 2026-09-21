<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Kendaraan</h4>
  <a href="index.php?page=kendaraan-form" class="btn btn-primary btn-sm">+ Tambah Kendaraan</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Nama</th><th>Plat</th><th>Harga per Hari</th><th style="width:170px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (count($kendaraan) === 0): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kendaraan</td></tr>
        <?php endif; ?>
        <?php foreach ($kendaraan as $i => $k): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($k['nama']) ?></td>
            <td><?= htmlspecialchars($k['plat']) ?></td>
            <td>Rp<?= number_format($k['harga_per_hari'], 0, ',', '.') ?></td>
            <td>
              <a href="index.php?page=kendaraan-form&id=<?= $k['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=kendaraan-hapus&id=<?= $k['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
