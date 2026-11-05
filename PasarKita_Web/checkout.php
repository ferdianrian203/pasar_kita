<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$cart=$_SESSION['cart'] ?? [];
if (!$cart) redirect('cart.php');
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $nama=trim($_POST['nama_pembeli'] ?? ''); $email=trim($_POST['email'] ?? '');
 $telepon=trim($_POST['telepon'] ?? ''); $alamat=trim($_POST['alamat'] ?? '');
 if ($nama==='' || $telepon==='' || $alamat==='') $error='Nama, nomor telepon, dan alamat wajib diisi.';
 else {
  try {
   $conn->begin_transaction(); $total=0; $lines=[];
   foreach($cart as $pid=>$qty) {
    $pid=(int)$pid; $qty=(int)$qty;
    $st=$conn->prepare("SELECT nama_produk,harga,stok FROM products WHERE id_product=? AND status='aktif' FOR UPDATE");
    $st->bind_param('i',$pid); $st->execute(); $p=$st->get_result()->fetch_assoc();
    if (!$p || $qty<1 || $p['stok']<$qty) throw new Exception('Stok salah satu produk tidak mencukupi. Silakan periksa keranjang.');
    $subtotal=$p['harga']*$qty; $total+=$subtotal;
    $lines[]=['id'=>$pid,'qty'=>$qty,'harga'=>$p['harga'],'subtotal'=>$subtotal];
   }
   // Pengguna guest disimpan sebagai data pemesan pada tabel orders; user_id boleh NULL.
   $st=$conn->prepare("INSERT INTO orders (user_id,nama_pembeli,email,telepon,alamat,total_harga,status_pesanan) VALUES (NULL,?,?,?,?,?,'Menunggu')");
   $st->bind_param('ssssd',$nama,$email,$telepon,$alamat,$total); $st->execute(); $orderId=$conn->insert_id;
   $detail=$conn->prepare("INSERT INTO order_details (id_order,id_product,jumlah,harga_satuan,subtotal) VALUES (?,?,?,?,?)");
   $stock=$conn->prepare("UPDATE products SET stok=stok-? WHERE id_product=?");
   foreach($lines as $line) {
    $detail->bind_param('iiidd',$orderId,$line['id'],$line['qty'],$line['harga'],$line['subtotal']); $detail->execute();
    $stock->bind_param('ii',$line['qty'],$line['id']); $stock->execute();
   }
   $conn->commit(); unset($_SESSION['cart']); $_SESSION['last_order']=$orderId; redirect('order_success.php');
  } catch(Throwable $ex) { $conn->rollback(); $error=$ex->getMessage(); }
 }
}
$pageTitle='Checkout'; require_once 'includes/header.php';
?>
<h1 class="h3 fw-bold mb-3">Form Pemesanan</h1>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="row g-4"><div class="col-lg-7"><form method="post" class="panel">
<div class="mb-3"><label class="form-label">Nama lengkap *</label><input class="form-control" name="nama_pembeli" required></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email"></div>
<div class="mb-3"><label class="form-label">Nomor telepon *</label><input class="form-control" name="telepon" required></div>
<div class="mb-3"><label class="form-label">Alamat pengiriman *</label><textarea class="form-control" name="alamat" rows="4" required></textarea></div>
<button class="btn btn-success">Buat Pesanan</button>
</form></div><div class="col-lg-5"><div class="panel"><h2 class="h5">Ringkasan</h2><?php $sum=0; foreach($cart as $pid=>$qty): $st=$conn->prepare("SELECT nama_produk,harga FROM products WHERE id_product=?"); $st->bind_param('i',$pid); $st->execute(); $p=$st->get_result()->fetch_assoc(); if($p): $sub=$p['harga']*$qty; $sum+=$sub; ?><div class="d-flex justify-content-between py-2 border-bottom"><span><?= e($p['nama_produk']) ?> × <?= (int)$qty ?></span><strong><?= rupiah($sub) ?></strong></div><?php endif; endforeach; ?><div class="d-flex justify-content-between pt-3"><strong>Total</strong><strong class="price"><?= rupiah($sum) ?></strong></div></div></div></div>
<?php require_once 'includes/footer.php'; ?>
