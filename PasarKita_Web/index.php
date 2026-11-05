<?php
require_once 'config/database.php';
$pageTitle = 'Beranda';
require_once 'includes/header.php';
$sql = "SELECT p.*, c.nama_kategori FROM products p LEFT JOIN categories c ON p.id_category=c.id_category WHERE p.status='aktif' ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>
<section class="hero mb-4">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <span class="badge bg-warning text-dark mb-3">Belanja produk lokal</span>
      <h1 class="display-5 fw-bold">Temukan produk tradisional pilihan.</h1>
      <p class="lead mb-0">Dari hasil bumi hingga kerajinan lokal, semua dalam satu tempat.</p>
    </div>
    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0"><i class="bi bi-basket2 display-1"></i></div>
  </div>
</section>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h2 class="h4 fw-bold mb-1">Produk pilihan</h2><p class="text-secondary mb-0">Jelajahi produk dari penjual lokal.</p></div>
</div>
<div class="row g-4">
<?php if ($result->num_rows): while($p=$result->fetch_assoc()): ?>
  <div class="col-6 col-md-4 col-lg-3">
    <div class="card product-card">
      <img src="<?= e($p['gambar'] ?: 'https://placehold.co/600x400?text=Produk') ?>" class="card-img-top" alt="<?= e($p['nama_produk']) ?>" onerror="this.src='https://placehold.co/600x400?text=Produk'">
      <div class="card-body">
        <small class="text-secondary"><?= e($p['nama_kategori'] ?? 'Produk') ?></small>
        <h3 class="h6 mt-1"><?= e($p['nama_produk']) ?></h3>
        <div class="price mb-3"><?= rupiah($p['harga']) ?></div>
        <a href="detail.php?id=<?= (int)$p['id_product'] ?>" class="btn btn-outline-success btn-sm mt-auto">Lihat detail</a>
      </div>
    </div>
  </div>
<?php endwhile; else: ?>
  <div class="col-12"><div class="alert alert-info">Belum ada produk. Silakan tambahkan produk melalui menu Admin.</div></div>
<?php endif; ?>
</div>
<?php require_once 'includes/footer.php'; ?>
