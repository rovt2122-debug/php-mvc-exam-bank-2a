<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Riwayat Transaksi</h4>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Waktu</th><th>Kasir</th><th>Item</th><th>Total</th><th>Bayar</th><th>Kembalian</th><th></th></tr>
      </thead>
      <tbody>
        <?php if (count($transaksi) === 0): ?>
          <tr><td colspan="8" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
        <?php endif; ?>
        <?php foreach ($transaksi as $i => $t): ?>
          <tr>
            <td><?= ($halaman - 1) * $perPage + $i + 1 ?></td>
            <td><?= $t['created_at'] ?></td>
            <td><?= htmlspecialchars($t['kasir']) ?></td>
            <td><?= $t['jumlah_item'] ?></td>
            <td>Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($t['bayar'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($t['kembalian'], 0, ',', '.') ?></td>
            <td>
              <a href="index.php?page=transaksi-detail&id=<?= $t['id'] ?>" class="btn btn-info btn-sm">Detail</a>
              <a href="index.php?page=riwayat-hapus&id=<?= $t['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
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
        <a class="page-link" href="index.php?page=riwayat&halaman=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
