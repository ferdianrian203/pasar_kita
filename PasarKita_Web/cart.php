<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    redirect('cart.php');
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id_product'] ?? 0);
    if ($action === 'add') {
        $qty = max(1, (int)($_POST['qty'] ?? 1));
        $st = $conn->prepare("SELECT stok FROM products WHERE id_product=? AND status='aktif'");
        $st->bind_param('i',$id); $st->execute(); $p=$st->get_result()->fetch_assoc();
        if ($p && $p['stok'] >= $qty) {
            $current = (int)($_SESSION['cart'][$id] ?? 0);
            $_SESSION['cart'][$id] = min($current + $qty, (int)$p['stok']);
            $_SESSION['flash'] = 'Produk berhasil ditambahkan ke keranjang.';
        } else $_SESSION['flash'] = 'Stok produk tidak mencukupi.';
    } elseif ($action === 'update') {
        foreach (($_POST['qty'] ?? []) as $pid=>$qty) {
            $pid=(int)$pid; $qty=(int)$qty;
            if ($qty <= 0) { unset($_SESSION['cart'][$pid]); continue; }
            $st=$conn->prepare("SELECT stok FROM products WHERE id_product=?");
            $st->bind_param('i',$pid); $st->execute(); $p=$st->get_result()->fetch_assoc();
            if ($p) $_SESSION['cart'][$pid]=min($qty,(int)$p['stok']);
        }
    } elseif ($action === 'remove') unset($_SESSION['cart'][$id]);
    redirect('cart.php');
}
$pageTitle='Keranjang Belanja';
require_once 'includes/header.php';
if (!empty($_SESSION['flash'])) { echo '<div class="alert alert-info">'.e($_SESSION['flash']).'</div>'; unset($_SESSION['flash']); }
$items=[]; $total=0;
foreach (($_SESSION['cart'] ?? []) as $id=>$qty) {
 $st=$conn->prepare("SELECT id_product,nama_produk,harga,stok,gambar FROM products WHERE id_product=?");
 $st->bind_param('i',$id); $st->execute(); $p=$st->get_result()->fetch_assoc();
 if ($p) { $p['qty']=$qty; $p['subtotal']=$p['harga']*$qty; $total+=$p['subtotal']; $items[]=$p; }
}
?>
<h1 class="h3 fw-bold mb-3">Keranjang Belanja</h1>
<?php if (!$items): ?>
<div class="panel text-center py-5"><i class="bi bi-basket display-3 text-success"></i><h2 class="h5 mt-3">Keranjang masih kosong</h2><a href="index.php" class="btn btn-success mt-2">Mulai belanja</a></div>
<?php else: ?>
<form method="post" class="panel"><input type="hidden" name="action" value="update">
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Produk</th><th>Harga</th><th style="width:130px">Jumlah</th><th>Subtotal</th><th></th></tr></thead><tbody>
<?php foreach($items as $it): ?><tr>
<td><div class="d-flex align-items-center gap-3"><img src="<?= e($it['gambar'] ?: 'https://placehold.co/100x80') ?>" width="72" height="60" style="object-fit:cover;border-radius:8px"><strong><?= e($it['nama_produk']) ?></strong></div></td>
<td><?= rupiah($it['harga']) ?></td><td><input class="form-control" type="number" min="0" max="<?= (int)$it['stok'] ?>" name="qty[<?= (int)$it['id_product'] ?>]" value="<?= (int)$it['qty'] ?>"></td>
<td class="fw-semibold"><?= rupiah($it['subtotal']) ?></td>
<td><a href="cart.php?remove=<?= (int)$it['id_product'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk dari keranjang?')"><i class="bi bi-trash"></i></a></td>
</tr><?php endforeach; ?>
</tbody></table></div>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3"><button class="btn btn-outline-success">Perbarui keranjang</button><div class="text-end"><div class="text-secondary">Total belanja</div><div class="price fs-4"><?= rupiah($total) ?></div><a href="checkout.php" class="btn btn-success mt-2">Lanjut pemesanan <i class="bi bi-arrow-right"></i></a></div></div>
</form>
<?php endif; require_once 'includes/footer.php'; ?>
