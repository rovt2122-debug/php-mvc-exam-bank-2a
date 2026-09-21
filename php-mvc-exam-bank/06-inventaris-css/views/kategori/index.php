<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=kategori-form" class="btn btn-primary btn-sm">+ Tambah Kategori</a>
</div>

<div class="card">
  <?php if (count($kategori) === 0): ?>
    <p class="kosong">Belum ada kategori</p>
  <?php else: ?>
    <table>
      <thead><tr><th>No</th><th>Nama Kategori</th><th style="width:150px;">Aksi</th></tr></thead>
      <tbody>
        <?php foreach ($kategori as $i => $k): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($k['nama']) ?></td>
            <td>
              <a href="index.php?page=kategori-form&id=<?= $k['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=kategori-hapus&id=<?= $k['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
