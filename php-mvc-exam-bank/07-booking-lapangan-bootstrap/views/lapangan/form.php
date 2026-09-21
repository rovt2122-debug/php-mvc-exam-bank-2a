<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $lapangan ? 'Edit Lapangan' : 'Tambah Lapangan' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=lapangan-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $lapangan['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama Lapangan</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($lapangan['nama'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Jenis</label>
        <input type="text" name="jenis" class="form-control" placeholder="futsal / basket / badminton"
          value="<?= htmlspecialchars($lapangan['jenis'] ?? '') ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=lapangan" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
