<?php
$pageTitle = 'Produk';
require_once 'includes/header.php';

// Filter
$search = isset($_GET['q']) ? sanitize($_GET['q']) : '';
$merk   = isset($_GET['merk']) ? sanitize($_GET['merk']) : '';

// Pagination
$perPage = 9;
$page    = max(1, (int)($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;

$where  = "WHERE 1=1";
if ($search) $where .= " AND (nama_barang LIKE '%$search%' OR merk LIKE '%$search%')";
if ($merk)   $where .= " AND merk = '$merk'";

$total    = $conn->query("SELECT COUNT(*) as c FROM barang $where")->fetch_assoc()['c'];
$pages    = ceil($total / $perPage);
$produk   = $conn->query("SELECT * FROM barang $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$merks    = $conn->query("SELECT DISTINCT merk FROM barang ORDER BY merk");
?>

<div style="padding: 100px 5% 60px; position:relative; z-index:1;">

  <!-- Page Header -->
  <div style="margin-bottom:36px;">
    <h1 style="font-size:clamp(1.8rem,4vw,2.8rem);">Semua <span class="gradient-text">Produk</span></h1>
    <p class="text-muted" style="margin-top:6px;">Temukan sneakers lokal favoritmu</p>
  </div>

  <!-- Filter Bar -->
  <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:36px; align-items:center;">
    <form method="GET" style="display:flex; gap:8px; flex:1; min-width:280px; max-width:400px;">
      <input type="text" name="q" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>"
             class="form-control" style="margin:0;">
      <?php if($merk): ?><input type="hidden" name="merk" value="<?= htmlspecialchars($merk) ?>"><?php endif; ?>
      <button type="submit" class="btn btn-primary" style="white-space:nowrap;">Cari</button>
    </form>

    <div style="display:flex; gap:6px; flex-wrap:wrap;">
      <a href="produk.php" class="btn btn-sm <?= !$merk?'btn-primary':'btn-outline' ?>">Semua</a>
      <?php while($m = $merks->fetch_assoc()): ?>
        <a href="produk.php?merk=<?= urlencode($m['merk']) ?><?= $search?"&q=".urlencode($search):'' ?>"
           class="btn btn-sm <?= $merk===$m['merk']?'btn-primary':'btn-outline' ?>">
          <?= htmlspecialchars($m['merk']) ?>
        </a>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Result count -->
  <p class="text-muted mb-3" style="font-size:.85rem;">
    Menampilkan <strong style="color:var(--white);"><?= $total ?></strong> produk
    <?= $search ? "untuk &quot;" . htmlspecialchars($search) . "&quot;" : '' ?>
    <?= $merk ? "dari brand <strong style='color:var(--purple-glow);'>$merk</strong>" : '' ?>
  </p>

  <!-- Grid -->
  <?php if ($produk->num_rows > 0): ?>
  <div class="product-grid">
    <?php while($row = $produk->fetch_assoc()): ?>
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
        <p class="card-desc"><?= htmlspecialchars(substr($row['deskripsi'], 0, 70)) ?>...</p>
        <div class="card-price"><?= formatRupiah($row['harga']) ?></div>

        <?php if($row['stok'] > 0): ?>
          <div class="stock-badge in-stock" style="margin-bottom:12px;">✓ Stok: <?= $row['stok'] ?></div>
        <?php else: ?>
          <div class="stock-badge out-stock" style="margin-bottom:12px;">✗ Habis</div>
        <?php endif; ?>

        <div class="card-footer-actions">
          <a href="detail.php?id=<?= $row['id_barang'] ?>" class="btn btn-outline btn-sm">Detail</a>
          <?php if(isUserLoggedIn() && $row['stok'] > 0): ?>
            <a href="user/keranjang.php?add=<?= $row['id_barang'] ?>" class="btn btn-primary btn-sm">+ Keranjang</a>
          <?php elseif(!isUserLoggedIn()): ?>
            <a href="login.php" class="btn btn-primary btn-sm">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <!-- Pagination -->
  <?php if($pages > 1): ?>
  <div class="pagination">
    <?php for($p = 1; $p <= $pages; $p++): ?>
      <a href="?page=<?= $p ?><?= $search?"&q=".urlencode($search):'' ?><?= $merk?"&merk=".urlencode($merk):'' ?>"
         class="page-btn <?= $p==$page?'active':'' ?>"><?= $p ?></a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>

  <?php else: ?>
  <div class="empty-state">
    <div class="icon">🔍</div>
    <h3>Produk tidak ditemukan</h3>
    <p>Coba kata kunci lain atau hapus filter pencarian</p>
    <a href="produk.php" class="btn btn-primary">Reset Pencarian</a>
  </div>
  <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>
