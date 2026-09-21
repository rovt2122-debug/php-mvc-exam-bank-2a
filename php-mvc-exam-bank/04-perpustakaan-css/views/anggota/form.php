<?php include __DIR__ . '/../partials/header.php'; ?>

<h1><?= $anggota ? 'Edit Anggota' : 'Tambah Anggota' ?></h1>

<div class="card" style="max-width:480px;">
  <form method="post" action="index.php?page=anggota-simpan">
    <input type="hidden" name="id" value="<?= $anggota['id'] ?? '' ?>">
    <label>Nama</label>
    <input type="text" name="nama" required value="<?= htmlspecialchars($anggota['nama'] ?? '') ?>">
    <label>Nomor Anggota</label>
    <input type="text" name="nomor_anggota" value="<?= htmlspecialchars($anggota['nomor_anggota'] ?? '') ?>">
    <label>Telepon</label>
    <input type="text" name="telepon" value="<?= htmlspecialchars($anggota['telepon'] ?? '') ?>">
    <div style="margin-top:16px;">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=anggota" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
