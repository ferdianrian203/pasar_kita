CREATE DATABASE IF NOT EXISTS db_marketplace CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_marketplace;

CREATE TABLE users (
 id_user INT AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(100) NOT NULL,
 email VARCHAR(120) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','penjual','pembeli') NOT NULL DEFAULT 'pembeli',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
 id_category INT AUTO_INCREMENT PRIMARY KEY,
 nama_kategori VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE products (
 id_product INT AUTO_INCREMENT PRIMARY KEY,
 id_category INT NOT NULL,
 id_user INT NULL,
 nama_produk VARCHAR(150) NOT NULL,
 deskripsi TEXT,
 harga DECIMAL(12,2) NOT NULL DEFAULT 0,
 stok INT NOT NULL DEFAULT 0,
 gambar VARCHAR(500),
 status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_product_category FOREIGN KEY (id_category) REFERENCES categories(id_category),
 CONSTRAINT fk_product_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE carts (
 id_cart INT AUTO_INCREMENT PRIMARY KEY,
 id_user INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uq_cart_user (id_user),
 CONSTRAINT fk_cart_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE cart_details (
 id_cart_detail INT AUTO_INCREMENT PRIMARY KEY,
 id_cart INT NOT NULL,
 id_product INT NOT NULL,
 jumlah INT NOT NULL DEFAULT 1,
 UNIQUE KEY uq_cart_product (id_cart,id_product),
 CONSTRAINT fk_cart_detail_cart FOREIGN KEY (id_cart) REFERENCES carts(id_cart) ON DELETE CASCADE,
 CONSTRAINT fk_cart_detail_product FOREIGN KEY (id_product) REFERENCES products(id_product)
) ENGINE=InnoDB;

CREATE TABLE orders (
 id_order INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NULL,
 nama_pembeli VARCHAR(120) NOT NULL,
 email VARCHAR(120),
 telepon VARCHAR(30) NOT NULL,
 alamat TEXT NOT NULL,
 total_harga DECIMAL(12,2) NOT NULL,
 status_pesanan ENUM('Menunggu','Diproses','Dikirim','Selesai','Dibatalkan') DEFAULT 'Menunggu',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_details (
 id_order_detail INT AUTO_INCREMENT PRIMARY KEY,
 id_order INT NOT NULL,
 id_product INT NOT NULL,
 jumlah INT NOT NULL,
 harga_satuan DECIMAL(12,2) NOT NULL,
 subtotal DECIMAL(12,2) NOT NULL,
 CONSTRAINT fk_order_detail_order FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE,
 CONSTRAINT fk_order_detail_product FOREIGN KEY (id_product) REFERENCES products(id_product)
) ENGINE=InnoDB;

INSERT INTO categories (nama_kategori) VALUES
('Hasil Pertanian'),('Makanan Tradisional'),('Kerajinan Tangan'),('Hasil Perkebunan');

INSERT INTO products (id_category,nama_produk,deskripsi,harga,stok,gambar,status) VALUES
(1,'Beras Lokal 5 Kg','Beras pilihan hasil pertanian lokal.',68000,25,'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800','aktif'),
(2,'Dodol Tradisional','Dodol tradisional dengan cita rasa khas.',35000,30,'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800','aktif'),
(3,'Anyaman Bambu','Kerajinan anyaman bambu buatan pengrajin lokal.',55000,12,'https://images.unsplash.com/photo-1603006905003-be475563bc59?w=800','aktif'),
(4,'Kopi Bubuk Lokal 250gr','Kopi bubuk pilihan dari perkebunan lokal.',42000,40,'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800','aktif');
