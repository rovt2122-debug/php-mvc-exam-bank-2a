<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=barang-form" class="btn btn-primary btn-sm">+ Tambah Barang</a>
</div>

<div class="card">
  <?php if (count($barang) === 0): ?>
    <p class="kosong">Belum ada barang</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Nama Barang</th><th>Kategori</th><th>Stok</th><th>Lokasi</th><th style="width:150px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($barang as $i => $b): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($b['nama']) ?></td>
            <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
            <td><?= $b['stok'] ?></td>
            <td><?= htmlspecialchars($b['lokasi']) ?></td>
            <td>
              <a href="index.php?page=barang-form&id=<?= $b['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=barang-hapus&id=<?= $b['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
