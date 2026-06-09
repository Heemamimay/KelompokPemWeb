<?php
$pageTitle = 'Tentang Kami';
require_once 'includes/header.php';
?>

<div style="padding: 100px 5% 60px; position:relative; z-index:1; max-width:900px; margin:0 auto;">

  <div class="animate-fade-in" style="text-align:center; margin-bottom:56px;">
    <div class="hero-badge" style="display:inline-flex;">✨ Story Kami</div>
    <h1 style="font-size:clamp(2rem,4vw,3rem); margin-top:16px;">
      Tentang <span class="gradient-text">SEMBARANG STORE</span>
    </h1>
    <p style="color:var(--white-dim); font-size:1rem; margin-top:12px; line-height:1.7; max-width:600px; margin-left:auto; margin-right:auto;">
      Kami hadir untuk memperkenalkan dan mendukung brand-brand sepatu lokal Indonesia yang berkualitas namun sering kurang dikenal.
    </p>
  </div>

  <!-- Mission Cards -->
  <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:24px; margin-bottom:60px;">
    <?php
    $cards = [
      ['🎯','Misi Kami','Menjadi platform terdepan untuk penjualan dan promosi brand sepatu lokal Indonesia yang berkualitas tinggi.'],
      ['👁️','Visi Kami','Indonesia dikenal dunia bukan hanya karena budayanya, tapi juga karena brand sepatunya yang keren.'],
      ['💎','Nilai Kami','Kualitas, Kejujuran, dan Dukungan penuh terhadap produk-produk buatan anak bangsa.'],
    ];
    foreach($cards as $c): ?>
    <div class="card animate-on-scroll" style="padding:28px; text-align:center;">
      <div style="font-size:2.5rem; margin-bottom:12px;"><?= $c[0] ?></div>
      <h3 style="margin-bottom:10px; font-size:1.1rem;"><?= $c[1] ?></h3>
      <p style="color:var(--white-dim); font-size:.875rem; line-height:1.7;"><?= $c[2] ?></p>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Brand yang Kami Jual -->
  <div class="animate-on-scroll" style="background:var(--card-bg); border:1px solid var(--card-border); border-radius:var(--radius-lg); padding:40px; margin-bottom:40px;">
    <h2 style="margin-bottom:24px; text-align:center;">Brand yang Kami <span class="gradient-text">Hadirkan</span></h2>
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:20px; text-align:center;">
      <?php
      $brands = [
        ['Compass','⭐','Brand lokal pioneer sneaker Indonesia sejak 1997'],
        ['Ventela','🌟','Sneaker premium lokal dengan kualitas terjangkau'],
        ['Aerostreet','💫','Sepatu sporty terjangkau favorit anak muda'],
        ['Piero','✨','Brand lari dan lifestyle terpercaya Indonesia'],
        ['NAH Project','🔥','Brand streetwear eksklusif & limited edition'],
      ];
      foreach($brands as $b): ?>
      <div class="card" style="padding:20px 16px;">
        <div style="font-size:2rem; margin-bottom:8px;"><?= $b[1] ?></div>
        <div style="font-weight:700; font-size:.95rem; margin-bottom:6px;"><?= $b[0] ?></div>
        <div style="font-size:.75rem; color:var(--white-dim); line-height:1.5;"><?= $b[2] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- CTA -->
  <div style="text-align:center;">
    <h2 style="margin-bottom:12px;">Mulai Belanja <span class="gradient-text">Sekarang</span></h2>
    <p style="color:var(--white-dim); margin-bottom:28px;">Dukung brand lokal Indonesia dengan setiap pembelianmu!</p>
    <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
      <a href="produk.php" class="btn btn-primary">🛍️ Lihat Produk</a>
      <?php if(!isUserLoggedIn()): ?>
      <a href="register.php" class="btn btn-gold">Daftar Sekarang</a>
      <?php endif; ?>
    </div>
  </div>

</div>

<?php require_once 'includes/footer.php'; ?>
