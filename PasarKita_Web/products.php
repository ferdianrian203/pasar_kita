<?php
require_once '../config/database.php'; require_once '../includes/functions.php'; require_admin();
$adminPage=true; $pageTitle='Kelola Produk'; require_once '../includes/header.php';
if (!empty($_SESSION['flash'])) { echo '<div class="alert alert-info">'.e($_SESSION['flash']).'</div>'; unset($_SESSION['flash']); }
$result=$conn->query("SELECT p.*,c.nama_kategori FROM products p LEFT JOIN categories c ON p.id_category=c.id_category ORDER BY p.created_at DESC");
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 fw-bold">Kelola Produk</h1><div><a href="product_form.php" class="btn btn-success">+ Tambah Produk</a> <a href="logout.php" class="btn btn-outline-secondary">Keluar</a></div></div>
<div class="panel table-responsive"><table class="table align-middle"><thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php while($p=$result->fetch_assoc()): ?><tr><td><?= e($p['nama_produk']) ?></td><td><?= e($p['nama_kategori']) ?></td><td><?= rupiah($p['harga']) ?></td><td><?= (int)$p['stok'] ?></td><td><?= e($p['status']) ?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="product_form.php?id=<?= (int)$p['id_product'] ?>">Edit</a> <form class="d-inline" method="post" action="product_delete.php" onsubmit="return confirm('Hapus produk ini?')"><input type="hidden" name="id" value="<?= (int)$p['id_product'] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endwhile; ?>
</tbody></table></div>
<?php require_once '../includes/footer.php'; ?>
