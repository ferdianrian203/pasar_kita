<?php
require_once 'config/database.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = $conn->prepare("SELECT p.*, c.nama_kategori FROM products p LEFT JOIN categories c ON p.id_category=c.id_category WHERE p.id_product=? AND p.status='aktif'");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$pageTitle = $product['nama_produk'] ?? 'Detail Produk';
require_once 'includes/header.php';
if (!$product): ?>
<div class="alert alert-warning">Produk tidak ditemukan.</div><a href="index.php" class="btn btn-success">Kembali</a>
<?php else: ?>
<div class="row g-4">
 <div class="col-md-6"><img class="product-detail-img" src="<?= e($product['gambar'] ?: 'https://placehold.co/800x600?text=Produk') ?>" alt="<?= e($product['nama_produk']) ?>"></div>
 <div class="col-md-6">
  <span class="badge text-bg-success"><?= e($product['nama_kategori'] ?? 'Produk') ?></span>
  <h1 class="h2 mt-2"><?= e($product['nama_produk']) ?></h1>
  <div class="price fs-3 mb-3"><?= rupiah($product['harga']) ?></div>
  <p><?= nl2br(e($product['deskripsi'])) ?></p>
  <p class="text-secondary">Stok tersedia: <?= (int)$product['stok'] ?></p>
  <form action="cart.php" method="post" class="d-flex gap-2 align-items-end">
   <input type="hidden" name="action" value="add"><input type="hidden" name="id_product" value="<?= (int)$product['id_product'] ?>">
   <div><label class="form-label">Jumlah</label><input class="form-control" type="number" name="qty" min="1" max="<?= (int)$product['stok'] ?>" value="1" required></div>
   <button class="btn btn-success" <?= $product['stok'] < 1 ? 'disabled' : '' ?>><i class="bi bi-cart-plus"></i> Tambah ke keranjang</button>
  </form>
 </div>
</div>
<?php endif; require_once 'includes/footer.php'; ?>
