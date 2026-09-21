<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Jadwal Lapangan</h4>
  <a href="index.php?page=jadwal-form" class="btn btn-primary btn-sm">+ Tambah Jadwal</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>No</th><th>Lapangan</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Harga per Jam</th><th style="width:170px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (count($jadwal) === 0): ?>
          <tr><td colspan="6" class="text-center text-muted py-4">Belum ada jadwal</td></tr>
        <?php endif; ?>
        <?php foreach ($jadwal as $i => $j): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($j['nama_lapangan']) ?></td>
            <td><?= substr($j['jam_mulai'], 0, 5) ?></td>
            <td><?= substr($j['jam_selesai'], 0, 5) ?></td>
            <td>Rp<?= number_format($j['harga_per_jam'], 0, ',', '.') ?></td>
            <td>
              <a href="index.php?page=jadwal-form&id=<?= $j['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="index.php?page=jadwal-hapus&id=<?= $j['id'] ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
