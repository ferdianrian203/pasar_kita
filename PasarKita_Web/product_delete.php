<?php
require_once '../config/database.php'; require_once '../includes/functions.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){$id=(int)($_POST['id']??0);$st=$conn->prepare("DELETE FROM products WHERE id_product=?");$st->bind_param('i',$id);$st->execute();$_SESSION['flash']='Produk berhasil dihapus.';}
redirect('products.php');
