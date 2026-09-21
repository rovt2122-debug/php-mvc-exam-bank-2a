<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Produk</h4>
  <a href="index.php?page=produk-form" class="btn btn-primary btn-sm">+ Tambah Produk</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Nama Produk</th><th>Harga</th><th style="width:170px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (count($produk) === 0): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada produk</td></tr>
        <?php endif; ?>
        <?php foreach ($produk as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td>Rp<?= number_format($p['harga'], 0, ',', '.') ?></td>
            <td>
              <a href="index.php?page=produk-form&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=produk-hapus&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
