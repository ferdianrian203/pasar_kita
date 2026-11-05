<?php
require_once 'config/database.php';
$pageTitle='Pesanan Berhasil'; require_once 'includes/header.php';
$id=(int)($_SESSION['last_order'] ?? 0);
?>
<div class="panel text-center py-5"><i class="bi bi-check-circle-fill text-success display-1"></i><h1 class="h3 mt-3">Pesanan berhasil dibuat!</h1><p class="text-secondary">Terima kasih telah berbelanja di PasarKita.</p><?php if($id): ?><p>Nomor pesanan Anda: <strong>#<?= $id ?></strong></p><?php endif; ?><a href="index.php" class="btn btn-success">Kembali berbelanja</a></div>
<?php require_once 'includes/footer.php'; ?>
