<?php
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function rupiah($angka) {
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}
function cart_count() {
    $total = 0;
    foreach (($_SESSION['cart'] ?? []) as $qty) $total += (int)$qty;
    return $total;
}
function redirect($url) {
    header("Location: $url");
    exit;
}
function require_admin() {
    if (empty($_SESSION['is_admin'])) redirect('login.php');
}
