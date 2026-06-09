<?php
$pageTitle = 'Beranda';
require_once 'includes/header.php';

// Ambil produk terbaru (6)
$produk = $conn->query("SELECT * FROM barang ORDER BY created_at DESC LIMIT 6");

// Statistik
$totalProduk    = $conn->query("SELECT COUNT(*) as c FROM barang")->fetch_assoc()['c'];
$totalPelanggan = $conn->query("SELECT COUNT(*) as c FROM pelanggan")->fetch_assoc()['c'];
$totalTrans     = $conn->query("SELECT COUNT(*) as c FROM transaksi")->fetch_assoc()['c'];
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-content animate-fade-in">
    <div class="hero-badge">✨ Brand Lokal Indonesia Terbaik</div>
    <h1>Temukan Sneakers <span class="gradient-text">Lokal Keren</span> Pilihanmu</h1>
    <p>Koleksi sepatu lokal premium dari Compass, Ventela, Aerostreet, Piero, NAH Project, dan brand kebanggaan Indonesia lainnya. Kualitas dunia, harga terjangkau.</p>
    <div class="hero-actions">
      <a href="produk.php" class="btn btn-primary">🛍️ Lihat Koleksi</a>
      <a href="tentang.php" class="btn btn-outline">Tentang Kami</a>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-strip">
  <div class="stat-item">
    <div class="stat-number"><?= $totalProduk ?>+</div>
    <div class="stat-label">Produk Tersedia</div>
  </div>
  <div class="stat-item">
    <div class="stat-number">5+</div>
    <div class="stat-label">Brand Lokal</div>
  </div>
  <div class="stat-item">
    <div class="stat-number"><?= $totalPelanggan ?>+</div>
    <div class="stat-label">Pelanggan</div>
  </div>
  <div class="stat-item">
    <div class="stat-number"><?= $totalTrans ?>+</div>
    <div class="stat-label">Transaksi Sukses</div>
  </div>
</div>

<!-- PRODUK TERBARU -->
<section class="section">
  <div class="section-header animate-on-scroll">
    <h2>Produk <span class="gradient-text">Terbaru</span></h2>
    <p>Koleksi sneakers lokal terkini pilihan redaksi SEMBARANG STORE</p>
  </div>

  <div class="product-grid">
    <?php while ($row = $produk->fetch_assoc()): ?>
    <div class="card product-card animate-on-scroll"
         data-name="<?= strtolower($row['nama_barang']) ?>"
         data-brand="<?= strtolower($row['merk']) ?>">

      <div class="card-img-placeholder" style="padding: 20px;">
        <img src="assets/images/<?= $row['gambar']?>" style="height:auto; width: 100%;">
        <span><?= htmlspecialchars($row['merk']) ?></span>
      </div>

      <div class="card-body">
        <span class="card-badge"><?= htmlspecialchars($row['merk']) ?></span>
        <h3 class="card-title"><?= htmlspecialchars($row['nama_barang']) ?></h3>
        <p class="card-desc"><?= htmlspecialchars(substr($row['deskripsi'], 0, 75)) ?>...</p>
        <div class="card-price"><?= formatRupiah($row['harga']) ?></div>
        <div class="card-footer-actions">
          <a href="detail.php?id=<?= $row['id_barang'] ?>" class="btn btn-outline btn-sm">Detail</a>
          <?php if(isUserLoggedIn()): ?>
            <a href="user/keranjang.php?add=<?= $row['id_barang'] ?>" class="btn btn-primary btn-sm">+ Keranjang</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-sm">Beli</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <div class="text-center mt-4">
    <a href="produk.php" class="btn btn-outline">Lihat Semua Produk →</a>
  </div>
</section>

<!-- BRANDS -->
<section class="section" style="background: rgba(123,47,255,.05); border-top:1px solid var(--card-border); border-bottom:1px solid var(--card-border);">
  <div class="section-header">
    <h2>Brand <span class="gradient-text">Lokal Pilihan</span></h2>
    <p>Kami hanya menjual produk original dari brand lokal terpercaya</p>
  </div>
  <div style="display:flex; gap:24px; flex-wrap:wrap; justify-content:center;">
    <?php
    $brands = ['Compass','Ventela','Aerostreet','Piero','NAH Project'];
    $icons  = ['⭐','🌟','💫','✨','🔥'];
    foreach($brands as $i => $b): ?>
    <div class="card animate-on-scroll" style="min-width:160px; text-align:center; padding:28px 20px;">
      <div style="font-size:2rem; margin-bottom:8px;"><?= $icons[$i] ?></div>
      <div style="font-weight:700; font-size:.95rem;"><?= $b ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA -->
<section class="section">
  <div style="text-align:center; max-width:560px; margin:0 auto;">
    <h2 class="animate-on-scroll">Siap Mulai <span class="gradient-text">Berbelanja?</span></h2>
    <p class="text-muted mt-2 mb-3" style="font-size:1rem; line-height:1.7;">
      Daftarkan akunmu sekarang dan nikmati pengalaman berbelanja sepatu lokal terbaik dengan mudah dan nyaman.
    </p>
    <?php if(!isUserLoggedIn()): ?>
    <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
      <a href="register.php" class="btn btn-gold">Daftar Gratis</a>
      <a href="login.php" class="btn btn-outline">Sudah punya akun</a>
    </div>
    <?php else: ?>
    <a href="produk.php" class="btn btn-primary">🛍️ Mulai Belanja</a>
    <?php endif; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
