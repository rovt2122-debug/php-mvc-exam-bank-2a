<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=peminjaman-form" class="btn btn-primary btn-sm">+ Peminjaman Baru</a>
</div>

<div class="card">
  <?php if (count($peminjaman) === 0): ?>
    <p class="kosong">Belum ada peminjaman</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Buku</th><th>Anggota</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th>
        <th>Dikembalikan</th><th>Denda</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($peminjaman as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['judul']) ?></td>
            <td><?= htmlspecialchars($p['nama_anggota']) ?></td>
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>
            <td><?= $p['tanggal_dikembalikan'] ?: '-' ?></td>
            <td><?= $p['denda'] > 0 ? 'Rp' . number_format($p['denda'], 0, ',', '.') : '-' ?></td>
            <td>
              <?php if ($p['status'] === 'dipinjam'): ?>
                <span class="badge badge-kuning">dipinjam</span>
              <?php else: ?>
                <span class="badge badge-hijau">kembali</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($p['status'] === 'dipinjam'): ?>
                <a href="index.php?page=peminjaman-kembali&id=<?= $p['id'] ?>" class="btn btn-sm btn-success">Kembalikan</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
