<?php
require_once '../config/database.php'; require_once '../includes/functions.php'; require_admin();
$id=(int)($_GET['id'] ?? 0); $p=['nama_produk'=>'','id_category'=>'','harga'=>'','stok'=>'','deskripsi'=>'','gambar'=>'','status'=>'aktif']; $error='';
if($id){$st=$conn->prepare("SELECT * FROM products WHERE id_product=?");$st->bind_param('i',$id);$st->execute();$found=$st->get_result()->fetch_assoc();if($found)$p=$found;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $nama=trim($_POST['nama_produk']??'');$cat=(int)($_POST['id_category']??0);$harga=(float)($_POST['harga']??0);$stok=(int)($_POST['stok']??0);$desc=trim($_POST['deskripsi']??'');$gambar=trim($_POST['gambar']??'');$status=$_POST['status']==='nonaktif'?'nonaktif':'aktif';
 if($nama===''||$cat<1||$harga<0||$stok<0)$error='Lengkapi data produk dengan benar.';
 else if($id){$st=$conn->prepare("UPDATE products SET nama_produk=?,id_category=?,harga=?,stok=?,deskripsi=?,gambar=?,status=? WHERE id_product=?");$st->bind_param('sidisssi',$nama,$cat,$harga,$stok,$desc,$gambar,$status,$id);$st->execute();redirect('products.php');}
 else {$seller=1;$st=$conn->prepare("INSERT INTO products (nama_produk,id_category,id_user,harga,stok,deskripsi,gambar,status) VALUES (?,?,NULL,?,?,?,?,?)");$st->bind_param('sidisss',$nama,$cat,$harga,$stok,$desc,$gambar,$status);$st->execute();redirect('products.php');}
}
$cats=$conn->query("SELECT * FROM categories ORDER BY nama_kategori");$adminPage=true;$pageTitle=$id?'Edit Produk':'Tambah Produk';require_once '../includes/header.php';
?>
<h1 class="h3 mb-3"><?= $id?'Edit':'Tambah' ?> Produk</h1><div class="panel"><form method="post">
<div class="mb-3"><label class="form-label">Nama produk</label><input class="form-control" name="nama_produk" value="<?= e($p['nama_produk']) ?>" required></div>
<div class="mb-3"><label class="form-label">Kategori</label><select class="form-select" name="id_category" required><option value="">Pilih kategori</option><?php while($c=$cats->fetch_assoc()): ?><option value="<?= $c['id_category'] ?>" <?= $p['id_category']==$c['id_category']?'selected':'' ?>><?= e($c['nama_kategori']) ?></option><?php endwhile; ?></select></div>
<div class="row"><div class="col-md-6 mb-3"><label class="form-label">Harga (Rp)</label><input type="number" min="0" class="form-control" name="harga" value="<?= e($p['harga']) ?>" required></div><div class="col-md-6 mb-3"><label class="form-label">Stok</label><input type="number" min="0" class="form-control" name="stok" value="<?= e($p['stok']) ?>" required></div></div>
<div class="mb-3"><label class="form-label">URL gambar (opsional)</label><input type="url" class="form-control" name="gambar" value="<?= e($p['gambar']) ?>"></div>
<div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control" name="deskripsi" rows="4"><?= e($p['deskripsi']) ?></textarea></div>
<div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="status"><option value="aktif" <?= $p['status']==='aktif'?'selected':'' ?>>Aktif</option><option value="nonaktif" <?= $p['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option></select></div>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><button class="btn btn-success">Simpan</button> <a href="products.php" class="btn btn-outline-secondary">Batal</a>
</form></div><?php require_once '../includes/footer.php'; ?>
