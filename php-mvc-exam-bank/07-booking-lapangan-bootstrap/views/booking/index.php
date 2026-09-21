<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Riwayat Booking</h4>
  <a href="index.php?page=booking-form" class="btn btn-primary btn-sm">+ Booking Baru</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Lapangan</th><th>Tanggal</th><th>Jam</th><th>Durasi</th><th>Total</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php if (count($booking) === 0): ?>
          <tr><td colspan="8" class="text-center text-muted py-4">Belum ada booking</td></tr>
        <?php endif; ?>
        <?php foreach ($booking as $i => $b): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($b['nama_lapangan']) ?></td>
            <td><?= date('d/m/Y', strtotime($b['tanggal'])) ?></td>
            <td><?= substr($b['jam_mulai'], 0, 5) ?> - <?= substr($b['jam_selesai'], 0, 5) ?></td>
            <td><?= $b['durasi'] ?> jam</td>
            <td>Rp<?= number_format($b['total'], 0, ',', '.') ?></td>
            <td>
              <?php
              $badge = ['aktif' => 'text-bg-success', 'selesai' => 'text-bg-secondary', 'batal' => 'text-bg-danger'];
              ?>
              <span class="badge <?= $badge[$b['status']] ?>"><?= $b['status'] ?></span>
            </td>
            <td>
              <?php if ($b['status'] === 'aktif'): ?>
                <a href="index.php?page=booking-batal&id=<?= $b['id'] ?>" class="btn btn-outline-danger btn-sm">Batalkan</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
