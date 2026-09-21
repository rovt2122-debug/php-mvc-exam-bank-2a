<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=stok-form" class="btn btn-primary btn-sm">+ Barang Masuk / Keluar</a>
</div>

<div class="card">
  <?php if (count($riwayat) === 0): ?>
    <p class="kosong">Belum ada perubahan stok</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Barang</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th><th>Waktu</th></tr>
      </thead>
      <tbody>
        <?php foreach ($riwayat as $i => $r): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($r['nama_barang']) ?></td>
            <td>
              <?php if ($r['jenis'] === 'masuk'): ?>
                <span class="badge badge-hijau">masuk</span>
              <?php else: ?>
                <span class="badge badge-merah">keluar</span>
              <?php endif; ?>
            </td>
            <td><?= $r['jumlah'] ?></td>
            <td><?= htmlspecialchars($r['keterangan']) ?></td>
            <td><?= $r['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
