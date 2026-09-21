<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=layanan-form" class="btn btn-primary btn-sm">+ Tambah Layanan</a>
</div>

<div class="card">
  <?php if (count($layanan) === 0): ?>
    <p class="kosong">Belum ada layanan</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Nama Layanan</th><th>Harga per Kg</th><th>Biaya Tambahan</th><th style="width:150px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($layanan as $i => $l): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($l['nama']) ?></td>
            <td>Rp<?= number_format($l['harga_per_kg'], 0, ',', '.') ?></td>
            <td><?= $l['biaya_tambahan'] > 0 ? 'Rp' . number_format($l['biaya_tambahan'], 0, ',', '.') : '-' ?></td>
            <td>
              <a href="index.php?page=layanan-form&id=<?= $l['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=layanan-hapus&id=<?= $l['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
