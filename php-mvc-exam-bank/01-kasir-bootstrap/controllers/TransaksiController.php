<?php

class TransaksiController
{
    private $produkModel;
    private $transaksiModel;

    public function __construct($pdo)
    {
        $this->produkModel = new Produk($pdo);
        $this->transaksiModel = new Transaksi($pdo);
    }

    public function kasir()
    {
        $produk = $this->produkModel->all();
        include __DIR__ . '/../views/transaksi/kasir.php';
    }

    public function tambahKeranjang()
    {
        $produkId = (int)($_POST['produk_id'] ?? 0);
        $qty = (int)($_POST['qty'] ?? 0);

        if ($produkId <= 0 || $qty <= 0) {
            $_SESSION['flash_error'] = 'Produk dan jumlah beli wajib diisi';
        } else {
            // keranjang disimpan di session, formatnya [produk_id => qty]
            $keranjang = $_SESSION['keranjang'] ?? [];
            $keranjang[$produkId] = ($keranjang[$produkId] ?? 0) + $qty;
            $_SESSION['keranjang'] = $keranjang;
        }
        header('Location: index.php?page=kasir');
        exit;
    }

    public function hapusItem()
    {
        $keranjang = $_SESSION['keranjang'] ?? [];
        unset($keranjang[(int)($_GET['id'] ?? 0)]);
        $_SESSION['keranjang'] = $keranjang;
        header('Location: index.php?page=kasir');
        exit;
    }

    public function bayar()
    {
        $keranjang = $_SESSION['keranjang'] ?? [];
        if (empty($keranjang)) {
            header('Location: index.php?page=kasir');
            exit;
        }

        $bayar = (int)($_POST['bayar'] ?? 0);
        $items = [];
        $total = 0;

        foreach ($keranjang as $produkId => $qty) {
            $produk = $this->produkModel->find($produkId);
            if (!$produk) continue;

            $harga = (int)$produk['harga'];
            $subtotal = $harga * $qty;
            $diskon = 0;

            // aturan diskon: kalau qty >= 10, 2 barang dihitung 50%
            // potongan = 2 x (harga / 2) = 1 x harga penuh
            if ($qty >= 10) {
                $diskon = $harga;
            }

            $items[] = [
                'produk_id' => $produkId,
                'harga' => $harga,
                'qty' => $qty,
                'diskon' => $diskon,
                'subtotal' => $subtotal - $diskon,
            ];
            $total += $subtotal - $diskon;
        }

        // pembayaran yang kurang dari total ditolak
        if ($bayar < $total) {
            $_SESSION['flash_error'] = 'Pembayaran kurang, totalnya Rp' . number_format($total, 0, ',', '.');
            header('Location: index.php?page=kasir');
            exit;
        }

        $transaksiId = $this->transaksiModel->simpan($_SESSION['user_id'], $items, $bayar);
        if (!$transaksiId) {
            $_SESSION['flash_error'] = 'Transaksi gagal disimpan';
            header('Location: index.php?page=kasir');
            exit;
        }

        unset($_SESSION['keranjang']);
        $_SESSION['flash_sukses'] = 'Transaksi berhasil disimpan';
        header('Location: index.php?page=transaksi-detail&id=' . $transaksiId);
        exit;
    }

    public function riwayat()
    {
        $transaksi = $this->transaksiModel->all();
        include __DIR__ . '/../views/transaksi/riwayat.php';
    }

    public function detail()
    {
        $transaksi = $this->transaksiModel->find($_GET['id'] ?? 0);
        if (!$transaksi) {
            header('Location: index.php?page=riwayat');
            exit;
        }
        $details = $this->transaksiModel->details($transaksi['id']);
        include __DIR__ . '/../views/transaksi/detail.php';
    }
}
