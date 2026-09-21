<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=pelanggan-form" class="btn btn-primary btn-sm">+ Tambah Pelanggan</a>
</div>

<div class="card">
  <?php if (count($pelanggan) === 0): ?>
    <p class="kosong">Belum ada pelanggan</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th style="width:150px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($pelanggan as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td><?= htmlspecialchars($p['telepon']) ?></td>
            <td><?= htmlspecialchars($p['alamat']) ?></td>
            <td>
              <a href="index.php?page=pelanggan-form&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=pelanggan-hapus&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
