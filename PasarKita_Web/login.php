<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $username=getenv('ADMIN_USER') ?: '';
 $hash=getenv('ADMIN_PASSWORD_HASH') ?: '';
 if ($username !== '' && $hash !== '' && hash_equals($username,trim($_POST['username'] ?? '')) && password_verify($_POST['password'] ?? '',$hash)) {
  session_regenerate_id(true); $_SESSION['is_admin']=true; redirect('products.php');
 } else $error='Username atau password salah.';
}
$pageTitle='Login Admin'; require_once '../includes/header.php';
?>
<div class="row justify-content-center"><div class="col-md-5"><div class="panel"><h1 class="h4 mb-3">Login Admin</h1><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required></div><div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div><button class="btn btn-success w-100">Masuk</button></form><small class="text-secondary d-block mt-3">Atur ADMIN_USER dan ADMIN_PASSWORD_HASH melalui environment server sebelum login.</small></div></div></div>
<?php require_once '../includes/footer.php'; ?>
