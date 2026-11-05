# PasarKita — Web Marketplace Tradisional

Aplikasi marketplace sederhana berbasis PHP Native, MySQLi, MySQL, dan Bootstrap 5.

## Fitur
- Daftar produk dan detail produk.
- Keranjang belanja berbasis PHP Session.
- Checkout dan penyimpanan pesanan beserta detail transaksi ke MySQL.
- Pengurangan stok menggunakan transaksi database.
- CRUD produk (tambah, lihat, ubah, hapus).
- Login admin berbasis password hash dari environment variable.

## Kebutuhan
- PHP 8.0 atau lebih baru (ekstensi mysqli aktif).
- MySQL 5.7+/MariaDB.
- Apache (XAMPP/Laragon) atau hosting PHP.
- Koneksi internet untuk Bootstrap CDN dan gambar contoh.

## Instalasi lokal (XAMPP)
1. Ekstrak folder `pasarkita_marketplace` ke `C:/xampp/htdocs/`.
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu Import, lalu impor `database/db_marketplace.sql`.
5. Jika perlu, sesuaikan `config/database.php` (default XAMPP: localhost, root, password kosong).
6. Buka `http://localhost/pasarkita_marketplace/`.

## Login admin
Login admin tidak menyediakan kredensial bawaan. Atur username dan hash password melalui environment variable sebelum masuk ke halaman admin.

Buat hash password dengan perintah:
```bash
php -r "echo password_hash('PASSWORD_KUAT_ANDA', PASSWORD_DEFAULT), PHP_EOL;"
```
Set environment variable pada server:
- `ADMIN_USER` = username admin yang diinginkan
- `ADMIN_PASSWORD_HASH` = hasil `password_hash()`
- `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` = konfigurasi database

Jangan commit password, hash password, atau kredensial hosting ke repository publik. Aplikasi mewajibkan environment variable untuk autentikasi admin; jangan menyimpan kredensial di repository.

## Struktur
- `config/` konfigurasi database
- `includes/` fungsi dan template
- `admin/` login dan CRUD produk
- `database/` SQL database dan data contoh
- `assets/` CSS
- `index.php`, `detail.php`, `cart.php`, `checkout.php` halaman pembeli

## ERD
Lihat `docs/erd.md`.

## Alur transaksi
Daftar produk → detail produk → tambah ke keranjang → ubah jumlah → checkout → validasi stok → simpan orders dan order_details → kurangi stok → tampilkan nomor pesanan.

## Catatan deployment
Source code ini belum otomatis ter-deploy. Unggah folder aplikasi ke hosting yang mendukung PHP dan buat database MySQL di hosting. Impor SQL, atur environment variable, lalu sesuaikan URL aplikasi bila dipasang pada subfolder. Pastikan URL demo yang diberikan dosen mengarah ke aplikasi dan database hosting yang sama.
