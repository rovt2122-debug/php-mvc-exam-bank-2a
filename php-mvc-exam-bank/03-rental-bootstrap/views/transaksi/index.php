<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Transaksi Rental</h4>
  <a href="index.php?page=transaksi-form" class="btn btn-primary btn-sm">+ Transaksi Baru</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Kendaraan</th><th>Pelanggan</th><th>Mulai</th><th>Selesai</th>
        <th>Hari</th><th>Total</th><th>Bayar</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php if (count($transaksi) === 0): ?>
          <tr><td colspan="9" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
        <?php endif; ?>
        <?php foreach ($transaksi as $i => $t): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($t['nama_kendaraan']) ?></td>
            <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['tanggal_mulai'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['tanggal_selesai'])) ?></td>
            <td><?= $t['jumlah_hari'] ?></td>
            <td>Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($t['bayar'], 0, ',', '.') ?></td>
            <td>
              <?php if ($t['status'] === 'lunas'): ?>
                <span class="badge text-bg-success">lunas</span>
              <?php else: ?>
                <span class="badge text-bg-warning">belum lunas
                  (sisa Rp<?= number_format($t['total'] - $t['bayar'], 0, ',', '.') ?>)</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
