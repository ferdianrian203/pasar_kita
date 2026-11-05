<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?>PasarKita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= isset($adminPage) ? '../assets/style.css' : 'assets/style.css' ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark pk-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= isset($adminPage) ? '../index.php' : 'index.php' ?>"><i class="bi bi-shop"></i> PasarKita</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="mainNav">
      <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <a class="nav-link" href="<?= isset($adminPage) ? '../index.php' : 'index.php' ?>">Beranda</a>
        <a class="nav-link" href="<?= isset($adminPage) ? '../cart.php' : 'cart.php' ?>"><i class="bi bi-bag"></i> Keranjang <span class="badge bg-warning text-dark"><?= cart_count() ?></span></a>
        <a class="btn btn-light btn-sm ms-lg-2" href="<?= isset($adminPage) ? 'products.php' : 'admin/login.php' ?>"><i class="bi bi-person-gear"></i> <?= isset($adminPage) ? 'Kelola Produk' : 'Admin' ?></a>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
