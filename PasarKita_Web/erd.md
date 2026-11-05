# ERD PasarKita

```mermaid
erDiagram
    USERS ||--o{ PRODUCTS : menawarkan
    CATEGORIES ||--o{ PRODUCTS : mengelompokkan
    USERS ||--o| CARTS : memiliki
    CARTS ||--o{ CART_DETAILS : berisi
    PRODUCTS ||--o{ CART_DETAILS : dipilih
    USERS ||--o{ ORDERS : membuat
    ORDERS ||--|{ ORDER_DETAILS : mempunyai
    PRODUCTS ||--o{ ORDER_DETAILS : dipesan

    USERS {
      int id_user PK
      varchar nama
      varchar email
      varchar password
      enum role
    }
    CATEGORIES {
      int id_category PK
      varchar nama_kategori
    }
    PRODUCTS {
      int id_product PK
      int id_category FK
      int id_user FK
      varchar nama_produk
      decimal harga
      int stok
      enum status
    }
    CARTS {
      int id_cart PK
      int id_user FK
    }
    CART_DETAILS {
      int id_cart_detail PK
      int id_cart FK
      int id_product FK
      int jumlah
    }
    ORDERS {
      int id_order PK
      int user_id FK
      varchar nama_pembeli
      decimal total_harga
      enum status_pesanan
    }
    ORDER_DETAILS {
      int id_order_detail PK
      int id_order FK
      int id_product FK
      int jumlah
      decimal harga_satuan
      decimal subtotal
    }
```

Catatan: checkout pada versi demo mendukung pembeli tanpa akun (guest), sehingga `orders.user_id` boleh NULL. Tabel carts dan cart_details disiapkan untuk pengembangan keranjang persisten bagi pengguna terdaftar; implementasi awal menyimpan keranjang di PHP Session.
