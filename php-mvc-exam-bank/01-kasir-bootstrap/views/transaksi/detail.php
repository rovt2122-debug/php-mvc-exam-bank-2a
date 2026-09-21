<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Detail Transaksi #<?= $transaksi['id'] ?></h4>
  <a href="index.php?page=riwayat" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <p class="mb-1">Waktu: <?= $transaksi['created_at'] ?></p>
    <p class="mb-0">Kasir: <?= htmlspecialchars($transaksi['kasir']) ?></p>
  </div>
</div>

<div class="card shadow-sm mb-3">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Diskon</th><th>Subtotal</th></tr></thead>
      <tbody>
        <?php foreach ($details as $d): ?>
          <tr>
            <td><?= htmlspecialchars($d['nama_produk']) ?></td>
            <td>Rp<?= number_format($d['harga'], 0, ',', '.') ?></td>
            <td><?= $d['qty'] ?></td>
            <td><?= $d['diskon'] > 0 ? 'Rp' . number_format($d['diskon'], 0, ',', '.') : '-' ?></td>
            <td>Rp<?= number_format($d['subtotal'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card shadow-sm" style="max-width:400px;">
  <div class="card-body">
    <div class="d-flex justify-content-between"><span>Total</span><strong>Rp<?= number_format($transaksi['total'], 0, ',', '.') ?></strong></div>
    <div class="d-flex justify-content-between"><span>Bayar</span><span>Rp<?= number_format($transaksi['bayar'], 0, ',', '.') ?></span></div>
    <div class="d-flex justify-content-between"><span>Kembalian</span><span>Rp<?= number_format($transaksi['kembalian'], 0, ',', '.') ?></span></div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
