<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3"><?= $kendaraan ? 'Edit Kendaraan' : 'Tambah Kendaraan' ?></h4>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="index.php?page=kendaraan-simpan" style="max-width:480px;">
      <input type="hidden" name="id" value="<?= $kendaraan['id'] ?? '' ?>">
      <div class="mb-3">
        <label class="form-label">Nama Kendaraan</label>
        <input type="text" name="nama" class="form-control" required
          value="<?= htmlspecialchars($kendaraan['nama'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Nomor Plat</label>
        <input type="text" name="plat" class="form-control"
          value="<?= htmlspecialchars($kendaraan['plat'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Harga per Hari</label>
        <input type="number" name="harga_per_hari" class="form-control" required min="1"
          value="<?= $kendaraan['harga_per_hari'] ?? '' ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php?page=kendaraan" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
