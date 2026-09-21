<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="text-kanan">
  <a href="index.php?page=transaksi-form" class="btn btn-primary btn-sm">+ Transaksi Baru</a>
</div>

<div class="card">
  <?php if (count($transaksi) === 0): ?>
    <p class="kosong">Belum ada transaksi</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Pelanggan</th><th>Layanan</th><th>Berat</th><th>Total</th>
        <th>Tanggal Masuk</th><th>Selesai</th><th>Status</th><th style="width:200px;">Ubah Status</th></tr>
      </thead>
      <tbody>
        <?php foreach ($transaksi as $i => $t): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
            <td><?= htmlspecialchars($t['nama_layanan']) ?></td>
            <td><?= $t['berat'] ?> kg</td>
            <td>Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
            <td><?= $t['tanggal_masuk'] ?></td>
            <td><?= $t['tanggal_selesai'] ?: '-' ?></td>
            <td>
              <?php
              $badge = ['diproses' => 'badge-kuning', 'dicuci' => 'badge-biru',
                        'selesai' => 'badge-hijau', 'diambil' => 'badge-abu'];
              ?>
              <span class="badge <?= $badge[$t['status']] ?>"><?= $t['status'] ?></span>
            </td>
            <td>
              <form method="get" action="index.php" style="display:flex; gap:6px;">
                <input type="hidden" name="page" value="transaksi-status">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <select name="status" style="width:auto; padding:4px 8px;">
                  <?php foreach (['diproses', 'dicuci', 'selesai', 'diambil'] as $s): ?>
                    <option value="<?= $s ?>" <?= $t['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                  <?php endforeach; ?>
                </select>
                <button class="btn btn-sm btn-secondary">Ubah</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
