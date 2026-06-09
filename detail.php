<?php
require_once 'includes/config.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: produk.php'); exit(); }

$stmt = $conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$barang = $stmt->get_result()->fetch_assoc();

if (!$barang) { header('Location: produk.php'); exit(); }

$pageTitle = $barang['nama_barang'];
require_once 'includes/header.php';

// Related products
$merk_safe = $conn->real_escape_string($barang['merk']);
$related = $conn->query("SELECT * FROM barang WHERE merk='$merk_safe' AND id_barang != $id LIMIT 4");
?>

<div style="padding: 100px 5% 60px; position:relative; z-index:1; max-width:1200px; margin:0 auto;">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Beranda</a>
    <span class="sep">›</span>
    <a href="produk.php">Produk</a>
    <span class="sep">›</span>
    <a href="produk.php?merk=<?= urlencode($barang['merk']) ?>"><?= htmlspecialchars($barang['merk']) ?></a>
    <span class="sep">›</span>
    <span class="current"><?= htmlspecialchars($barang['nama_barang']) ?></span>
  </div>

  <!-- Detail Layout -->
  <div class="detail-layout">
    <!-- Image -->
    <div class="detail-img">
      <div style="width:100%; height:100%; min-height:380px; background:linear-gradient(135deg, rgba(123,47,255,.3), rgba(61,0,128,.5)); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px;">
        <div style="font-size:6rem;">👟</div>
        <span style="font-size:.9rem; color:var(--white-dim);"><?= htmlspecialchars($barang['merk']) ?></span>
      </div>
    </div>

    <!-- Info -->
    <div class="detail-info animate-fade-in">
      <span class="card-badge" style="font-size:.8rem; padding:5px 14px;"><?= htmlspecialchars($barang['merk']) ?></span>
      <h1 style="font-size:1.8rem; margin-top:12px; margin-bottom:4px;"><?= htmlspecialchars($barang['nama_barang']) ?></h1>

      <div class="price"><?= formatRupiah($barang['harga']) ?></div>

      <div class="detail-meta">
        <div class="detail-meta-item"><strong>Brand:</strong> <?= htmlspecialchars($barang['merk']) ?></div>
        <div class="detail-meta-item">
          <?php if($barang['stok'] > 0): ?>
            <span class="stock-badge in-stock">✓ Stok Tersedia (<?= $barang['stok'] ?>)</span>
          <?php else: ?>
            <span class="stock-badge out-stock">✗ Stok Habis</span>
          <?php endif; ?>
        </div>
      </div>

      <p style="color:var(--white-dim); line-height:1.8; margin-bottom:28px; font-size:.95rem;">
        <?= nl2br(htmlspecialchars($barang['deskripsi'])) ?>
      </p>

      <?php if(isUserLoggedIn() && $barang['stok'] > 0): ?>
      <form action="user/keranjang.php" method="GET" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
        <input type="hidden" name="add" value="<?= $barang['id_barang'] ?>">
        <a href="user/keranjang.php?add=<?= $barang['id_barang'] ?>" class="btn btn-primary" style="flex:1; justify-content:center; min-width:180px;">
          🛒 Tambah ke Keranjang
        </a>
      </form>
      <?php elseif(!isUserLoggedIn()): ?>
      <a href="login.php" class="btn btn-primary btn-block">Login untuk Membeli</a>
      <?php else: ?>
      <div class="alert alert-warning">Maaf, stok produk ini sedang habis.</div>
      <?php endif; ?>

      <a href="produk.php" class="btn btn-outline mt-2">← Kembali ke Produk</a>
    </div>
  </div>

  <!-- Related Products -->
  <?php if($related->num_rows > 0): ?>
  <div style="margin-top:60px;">
    <h2 style="margin-bottom:28px;">Produk <span class="gradient-text">Serupa</span></h2>
    <div class="product-grid">
      <?php while($rel = $related->fetch_assoc()): ?>
      <div class="card animate-on-scroll">
        <div class="card-img-placeholder">
          <div class="icon">👟</div>
          <span><?= htmlspecialchars($rel['merk']) ?></span>
        </div>
        <div class="card-body">
          <span class="card-badge"><?= htmlspecialchars($rel['merk']) ?></span>
          <h3 class="card-title"><?= htmlspecialchars($rel['nama_barang']) ?></h3>
          <div class="card-price"><?= formatRupiah($rel['harga']) ?></div>
          <a href="detail.php?id=<?= $rel['id_barang'] ?>" class="btn btn-outline btn-sm btn-block">Lihat Detail</a>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>
