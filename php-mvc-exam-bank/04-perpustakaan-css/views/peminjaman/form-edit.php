<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Edit Peminjaman</h1>

<div class="card" style="max-width:520px;">
  <form method="post" action="index.php?page=peminjaman-simpan">
    <input type="hidden" name="id" value="<?= $pinjam['id'] ?>">

    <label>Buku</label>
    <p style="margin:0 0 12px;"><?= htmlspecialchars($pinjam['judul']) ?></p>

    <label>Anggota</label>
    <p style="margin:0 0 12px;"><?= htmlspecialchars($pinjam['nama_anggota']) ?></p>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" value="<?= $pinjam['tanggal_pinjam'] ?>" required>

    <label>Tanggal Kembali (jatuh tempo)</label>
    <input type="date" name="tanggal_kembali" value="<?= $pinjam['tanggal_kembali'] ?>" required>

    <label>Denda (Rp)</label>
    <input type="number" name="denda" min="0" value="<?= (int)$pinjam['denda'] ?>">
    <p class="sub" style="margin-top:4px;">Isi 0 kalau denda sudah lunas, atau sesuaikan kalau dibayar cicil.</p>

    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=peminjaman" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
