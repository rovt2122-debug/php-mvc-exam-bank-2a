<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=buku-form" class="btn btn-primary btn-sm">+ Tambah Buku</a>
</div>

<div class="card">
  <?php if (count($buku) === 0): ?>
    <p class="kosong">Belum ada buku</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Judul</th><th>Pengarang</th><th>Tahun</th><th>Stok</th><th style="width:150px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($buku as $i => $b): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($b['judul']) ?></td>
            <td><?= htmlspecialchars($b['pengarang']) ?></td>
            <td><?= $b['tahun'] ?></td>
            <td><?= $b['stok'] > 0 ? $b['stok'] : '<span class="badge badge-merah">habis</span>' ?></td>
            <td>
              <a href="index.php?page=buku-form&id=<?= $b['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=buku-hapus&id=<?= $b['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
