<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Peminjaman Baru</h1>

<div class="card" style="max-width:520px;">
  <form method="post" action="index.php?page=peminjaman-simpan">
    <label>Buku</label>
    <select name="buku_id" required>
      <option value="">- pilih buku -</option>
      <?php foreach ($buku as $b): ?>
        <option value="<?= $b['id'] ?>">
          <?= htmlspecialchars($b['judul']) ?> (stok: <?= $b['stok'] ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <label>Anggota</label>
    <select name="anggota_id" required>
      <option value="">- pilih anggota -</option>
      <?php foreach ($anggota as $a): ?>
        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama']) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>

    <label>Tanggal Kembali (jatuh tempo)</label>
    <input type="date" name="tanggal_kembali" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>

    <p class="sub" style="margin-top:8px;">Terlambat mengembalikan kena denda Rp1.000 per hari.</p>

    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=peminjaman" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
