<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $kelas ? 'Edit Kelas' : 'Tambah Kelas' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=kelas-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $kelas['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama Kelas</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($kelas['nama'] ?? '') ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=kelas" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
