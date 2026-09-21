import sharp from 'sharp';
import opentype from 'opentype.js';
import { readFileSync } from 'fs';

const ROOT = '/vercel/share/v0-project/php-mvc-exam-bank';
const loadFont = (p) => {
  const buf = readFileSync(p);
  return opentype.parse(buf.buffer.slice(buf.byteOffset, buf.byteOffset + buf.byteLength));
};
const fontRegular = loadFont('/tmp/erd-fonts/pjs-400.ttf');
const fontBold = loadFont('/tmp/erd-fonts/pjs-700.ttf');

// render teks jadi path svg per-karakter (bypass GSUB yang tidak didukung opentype.js)
function textPath(text, x, y, size, fill, anchor = 'start', bold = false) {
  const f = bold ? fontBold : fontRegular;
  const scale = size / f.unitsPerEm;
  const width = [...text].reduce((w, ch) => w + (f.charToGlyph(ch)?.advanceWidth ?? 0) * scale, 0);
  let px = x;
  if (anchor === 'middle') px = x - width / 2;
  if (anchor === 'end') px = x - width;
  let d = '';
  for (const ch of text) {
    const glyph = f.charToGlyph(ch);
    if (glyph) d += glyph.getPath(px, y, size).toPathData(2);
    px += (glyph?.advanceWidth ?? 0) * scale;
  }
  const stroke = bold ? ` stroke="${fill}" stroke-width="0.6"` : '';
  return `<path d="${d}" fill="${fill}"${stroke}/>`;
}

const erds = {
  '01-kasir-bootstrap': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'produk', x: 40, y: 230, cols: ['id (PK)', 'nama', 'harga'] },
      { name: 'transaksi', x: 340, y: 40, cols: ['id (PK)', 'user_id (FK)', 'total', 'bayar', 'kembalian', 'created_at'] },
      { name: 'transaksi_detail', x: 340, y: 260, cols: ['id (PK)', 'transaksi_id (FK)', 'produk_id (FK)', 'harga', 'qty', 'diskon', 'subtotal'] },
    ],
    rels: [
      ['users', 'transaksi', '1', 'N'],
      ['transaksi', 'transaksi_detail', '1', 'N'],
      ['produk', 'transaksi_detail', '1', 'N'],
    ],
  },
  '02-laundry-css': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'pelanggan', x: 40, y: 230, cols: ['id (PK)', 'nama', 'telepon', 'alamat'] },
      { name: 'layanan', x: 40, y: 390, cols: ['id (PK)', 'nama', 'harga_per_kg', 'biaya_tambahan'] },
      { name: 'transaksi', x: 340, y: 40, cols: ['id (PK)', 'pelanggan_id (FK)', 'layanan_id (FK)', 'berat', 'harga_per_kg', 'biaya_tambahan', 'total', 'status', 'tanggal_masuk', 'tanggal_selesai', 'created_at'] },
    ],
    rels: [
      ['pelanggan', 'transaksi', '1', 'N'],
      ['layanan', 'transaksi', '1', 'N'],
    ],
  },
  '03-rental-bootstrap': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'kendaraan', x: 40, y: 230, cols: ['id (PK)', 'nama', 'plat', 'harga_per_hari'] },
      { name: 'pelanggan', x: 40, y: 400, cols: ['id (PK)', 'nama', 'telepon', 'alamat'] },
      { name: 'transaksi', x: 340, y: 40, cols: ['id (PK)', 'kendaraan_id (FK)', 'pelanggan_id (FK)', 'tanggal_mulai', 'tanggal_selesai', 'harga_per_hari', 'jumlah_hari', 'total', 'bayar', 'kembalian', 'status', 'created_at'] },
    ],
    rels: [
      ['kendaraan', 'transaksi', '1', 'N'],
      ['pelanggan', 'transaksi', '1', 'N'],
    ],
  },
  '04-perpustakaan-css': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'buku', x: 40, y: 230, cols: ['id (PK)', 'judul', 'pengarang', 'tahun', 'stok'] },
      { name: 'anggota', x: 40, y: 410, cols: ['id (PK)', 'nama', 'nomor_anggota', 'telepon'] },
      { name: 'peminjaman', x: 340, y: 40, cols: ['id (PK)', 'buku_id (FK)', 'anggota_id (FK)', 'tanggal_pinjam', 'tanggal_kembali', 'tanggal_dikembalikan', 'denda', 'status', 'created_at'] },
    ],
    rels: [
      ['buku', 'peminjaman', '1', 'N'],
      ['anggota', 'peminjaman', '1', 'N'],
    ],
  },
  '05-absensi-bootstrap': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'kelas', x: 40, y: 230, cols: ['id (PK)', 'nama'] },
      { name: 'siswa', x: 40, y: 330, cols: ['id (PK)', 'nama', 'kelas_id (FK)'] },
      { name: 'absensi', x: 340, y: 40, cols: ['id (PK)', 'siswa_id (FK)', 'tanggal', 'status', 'jam_masuk', 'created_at'] },
    ],
    rels: [
      ['kelas', 'siswa', '1', 'N'],
      ['siswa', 'absensi', '1', 'N'],
    ],
  },
  '06-inventaris-css': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'kategori', x: 40, y: 230, cols: ['id (PK)', 'nama'] },
      { name: 'barang', x: 40, y: 340, cols: ['id (PK)', 'nama', 'kategori_id (FK)', 'stok', 'lokasi'] },
      { name: 'riwayat_stok', x: 340, y: 40, cols: ['id (PK)', 'barang_id (FK)', 'jenis', 'jumlah', 'keterangan', 'created_at'] },
    ],
    rels: [
      ['kategori', 'barang', '1', 'N'],
      ['barang', 'riwayat_stok', '1', 'N'],
    ],
  },
  '07-booking-lapangan-bootstrap': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'created_at'] },
      { name: 'lapangan', x: 40, y: 230, cols: ['id (PK)', 'nama', 'jenis'] },
      { name: 'jadwal', x: 40, y: 370, cols: ['id (PK)', 'lapangan_id (FK)', 'jam_mulai', 'jam_selesai', 'harga_per_jam'] },
      { name: 'booking', x: 340, y: 40, cols: ['id (PK)', 'lapangan_id (FK)', 'jadwal_id (FK)', 'tanggal', 'jam_mulai', 'jam_selesai', 'durasi', 'total', 'status', 'created_at'] },
    ],
    rels: [
      ['lapangan', 'jadwal', '1', 'N'],
      ['lapangan', 'booking', '1', 'N'],
      ['jadwal', 'booking', '1', 'N'],
    ],
  },
  '08-pengaduan-fasilitas-css': {
    tables: [
      { name: 'users', x: 40, y: 40, cols: ['id (PK)', 'nama', 'email', 'password', 'role', 'created_at'] },
      { name: 'kategori', x: 40, y: 280, cols: ['id (PK)', 'nama'] },
      { name: 'pengaduan', x: 340, y: 40, cols: ['id (PK)', 'user_id (FK)', 'kategori_id (FK)', 'judul', 'deskripsi', 'lokasi', 'status', 'created_at'] },
    ],
    rels: [
      ['users', 'pengaduan', '1', 'N'],
      ['kategori', 'pengaduan', '1', 'N'],
    ],
  },
};

const W = 230, TITLE_H = 32, ROW_H = 24, PAD = 10;

function esc(s) {
  return s.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');
}

function buildSvg(erd) {
  const boxes = {};
  let maxX = 0, maxY = 0;

  for (const t of erd.tables) {
    const h = TITLE_H + t.cols.length * ROW_H + PAD;
    boxes[t.name] = { ...t, w: W, h };
    maxX = Math.max(maxX, t.x + W);
    maxY = Math.max(maxY, t.y + h);
  }

  let svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${maxX + 40}" height="${maxY + 40}" viewBox="0 0 ${maxX + 40} ${maxY + 40}">`;
  svg += `<rect width="100%" height="100%" fill="#f8fafc"/>`;

  // garis relasi digambar dulu supaya ada di balik kotak tabel
  for (const [from, to, card1, card2] of erd.rels) {
    const a = boxes[from], b = boxes[to];
    const x1 = a.x + a.w / 2, y1 = a.y + a.h / 2;
    const x2 = b.x + b.w / 2, y2 = b.y + b.h / 2;
    svg += `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="#94a3b8" stroke-width="2"/>`;

    // cari titik keluar kotak A dan masuk kotak B biar label 1/N tidak ketutup
    const dx = x2 - x1, dy = y2 - y1;
    const tExit = (box) => {
      const tx = dx > 0 ? (box.x + box.w - x1) / dx : (box.x - x1) / dx;
      const ty = dy > 0 ? (box.y + box.h - y1) / dy : (box.y - y1) / dy;
      return Math.min(tx, ty);
    };
    const tEnter = (box) => {
      const tx = dx > 0 ? (box.x - x1) / dx : (box.x + box.w - x1) / dx;
      const ty = dy > 0 ? (box.y - y1) / dy : (box.y + box.h - y1) / dy;
      return Math.max(tx, ty);
    };
    const tA = tExit(a);
    const tB = tEnter(b);
    const gap = tB - tA;
    const label = (t, text) =>
      textPath(text, x1 + dx * t, y1 + dy * t + 5, 14, '#334155', 'middle', true);
    svg += label(tA + gap * 0.2, card1);
    svg += label(tA + gap * 0.8, card2);
  }

  for (const t of erd.tables) {
    const b = boxes[t.name];
    svg += `<rect x="${b.x}" y="${b.y}" width="${b.w}" height="${b.h}" rx="8" fill="#ffffff" stroke="#cbd5e0" stroke-width="1.5"/>`;
    svg += `<path d="M ${b.x} ${b.y + 8} a8 8 0 0 1 8 -8 h ${b.w - 16} a8 8 0 0 1 8 8 v ${TITLE_H - 8} h ${-b.w} Z" fill="#1e3a5f"/>`;
    svg += textPath(t.name, b.x + b.w / 2, b.y + 21, 15, '#ffffff', 'middle', true);
    t.cols.forEach((col, i) => {
      const y = b.y + TITLE_H + 17 + i * ROW_H;
      const isPk = col.includes('(PK)');
      const isFk = col.includes('(FK)');
      const color = isPk ? '#b71540' : isFk ? '#1e5aa8' : '#1f2933';
      const weight = isPk ? 'bold' : 'normal';
      svg += textPath(col, b.x + 14, y, 13, color, 'start', isPk);
      if (i < t.cols.length - 1) {
        svg += `<line x1="${b.x + 10}" y1="${y + 7}" x2="${b.x + b.w - 10}" y2="${y + 7}" stroke="#eef1f4" stroke-width="1"/>`;
      }
    });
  }

  svg += '</svg>';
  return svg;
}

for (const [folder, erd] of Object.entries(erds)) {
  const svg = buildSvg(erd);
  await sharp(Buffer.from(svg)).png().toFile(`${ROOT}/${folder}/ERD.png`);
  console.log('ok', folder);
}
