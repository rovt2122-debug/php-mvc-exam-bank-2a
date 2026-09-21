<?php include __DIR__ . '/../partials/header.php'; ?>

<h4 class="mb-3">Kasir</h4>

<div class="row">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="mb-3">Tambah Produk</h6>
        <form method="post" action="index.php?page=kasir-tambah">
          <div class="mb-3">
            <label class="form-label">Produk</label>
            <select name="produk_id" class="form-select" required>
              <option value="">- pilih produk -</option>
              <?php foreach ($produk as $p): ?>
                <option value="<?= $p['id'] ?>">
                  <?= htmlspecialchars($p['nama']) ?> - Rp<?= number_format($p['harga'], 0, ',', '.') ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah Beli</label>
            <input type="number" name="qty" class="form-control" min="1" value="1" required>
          </div>
          <button class="btn btn-primary w-100">Tambah ke Keranjang</button>
        </form>
        <div class="alert alert-info mt-3 mb-0 py-2 small">
          Beli 10 buah atau lebih: 2 barang dihitung setengah harga.
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="mb-3">Keranjang</h6>
        <?php $keranjang = $_SESSION['keranjang'] ?? []; ?>
        <?php if (count($keranjang) === 0): ?>
          <p class="text-center text-muted py-4 mb-0">Keranjang masih kosong</p>
        <?php else: ?>
          <table class="table align-middle">
            <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
            <tbody>
              <?php $total = 0; ?>
              <?php foreach ($keranjang as $produkId => $qty): ?>
                <?php
                $p = null;
                foreach ($produk as $item) {
                    if ($item['id'] == $produkId) { $p = $item; break; }
                }
                if (!$p) continue;
                // preview diskon, logicnya sama dengan saat bayar
                $subtotal = $p['harga'] * $qty;
                $diskon = ($qty >= 10) ? $p['harga'] : 0;
                $total += $subtotal - $diskon;
                ?>
                <tr>
                  <td><?= htmlspecialchars($p['nama']) ?></td>
                  <td>Rp<?= number_format($p['harga'], 0, ',', '.') ?></td>
                  <td><?= $qty ?></td>
                  <td>Rp<?= number_format($subtotal - $diskon, 0, ',', '.') ?>
                    <?php if ($diskon > 0): ?><span class="badge text-bg-success">diskon</span><?php endif; ?>
                  </td>
                  <td><a href="index.php?page=kasir-hapus-item&id=<?= $produkId ?>"
                    class="btn btn-sm btn-outline-danger btn-hapus">x</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <form method="post" action="index.php?page=kasir-bayar" class="row g-2 align-items-end">
            <div class="col-auto">
              <label class="form-label">Total</label>
              <div class="fs-5 fw-bold">Rp<?= number_format($total, 0, ',', '.') ?></div>
            </div>
            <div class="col">
              <label class="form-label">Pembayaran</label>
              <input type="number" name="bayar" class="form-control" min="0" required>
            </div>
            <div class="col-auto">
              <button class="btn btn-success">Bayar</button>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
