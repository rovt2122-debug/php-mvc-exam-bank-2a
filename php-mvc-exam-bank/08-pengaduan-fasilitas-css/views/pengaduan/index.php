<?php include __DIR__ . '/../partials/header.php'; ?>

<?php $admin = ($_SESSION['user_role'] ?? '') === 'admin'; ?>

<div class="text-kanan">
  <a href="index.php?page=pengaduan-form" class="btn btn-primary btn-sm">+ Buat Pengaduan</a>
</div>

<div class="card">
  <?php if (count($pengaduan) === 0): ?>
    <p class="kosong">Belum ada pengaduan</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Lokasi</th>
        <?php if ($admin): ?><th>Pelapor</th><?php endif; ?>
        <th>Tanggal Laporan</th><th>Status</th><th style="width:210px;">Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($pengaduan as $i => $p): ?>
          <tr>
            <td><?= ($halaman - 1) * $perPage + $i + 1 ?></td>
            <td><?= htmlspecialchars($p['judul']) ?></td>
            <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($p['lokasi']) ?></td>
            <?php if ($admin): ?><td><?= htmlspecialchars($p['nama_pelapor']) ?></td><?php endif; ?>
            <td><?= $p['created_at'] ?></td>
            <td>
              <?php
              $badge = ['diajukan' => 'badge-kuning', 'diproses' => 'badge-biru', 'selesai' => 'badge-hijau'];
              ?>
              <span class="badge <?= $badge[$p['status']] ?>"><?= $p['status'] ?></span>
            </td>
            <td>
              <?php if ($admin && $p['status'] !== 'selesai'): ?>
                <a href="index.php?page=pengaduan-status&id=<?= $p['id'] ?>&status=diproses"
                  class="btn btn-sm btn-secondary">Proses</a>
              <?php endif; ?>
              <?php if ($admin && $p['status'] !== 'selesai'): ?>
                <a href="index.php?page=pengaduan-status&id=<?= $p['id'] ?>&status=selesai"
                  class="btn btn-sm btn-success">Selesai</a>
              <?php endif; ?>
              <?php if ($p['status'] === 'diajukan' && ((int)$p['user_id'] === (int)$_SESSION['user_id'] || $admin)): ?>
                <a href="index.php?page=pengaduan-form&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                <a href="index.php?page=pengaduan-hapus&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger btn-hapus">Hapus</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php if ($totalHalaman > 1): ?>
<div class="text-kanan" style="margin-top:12px;">
  <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
    <a href="index.php?page=pengaduan&halaman=<?= $i ?>"
       class="btn btn-sm <?= $i === $halaman ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
