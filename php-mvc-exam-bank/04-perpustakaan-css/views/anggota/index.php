<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=anggota-form" class="btn btn-primary btn-sm">+ Tambah Anggota</a>
</div>

<div class="card">
  <?php if (count($anggota) === 0): ?>
    <p class="kosong">Belum ada anggota</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Nama</th><th>Nomor Anggota</th><th>Telepon</th><th style="width:150px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($anggota as $i => $a): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($a['nama']) ?></td>
            <td><?= htmlspecialchars($a['nomor_anggota']) ?></td>
            <td><?= htmlspecialchars($a['telepon']) ?></td>
            <td>
              <a href="index.php?page=anggota-form&id=<?= $a['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="index.php?page=anggota-hapus&id=<?= $a['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
