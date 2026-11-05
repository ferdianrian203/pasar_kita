<?php
// Konfigurasi database. Gunakan environment variable pada hosting.
// Untuk XAMPP lokal, sesuaikan nilai default berikut.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$dbHost = getenv('DB_HOST') ?: 'sql106.infinityfree.com';
$dbUser = getenv('DB_USER') ?: 'if0_42987834';
$dbPass = getenv('DB_PASS') ?: 'Rian1234Rian ';
$dbName = getenv('DB_NAME') ?: 'if0_42987834_pasar_kita';

try {
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi database.');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
