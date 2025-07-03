# POS API

API ini adalah backend untuk aplikasi Point of Sale (POS) berbasis Laravel. API menyediakan fitur autentikasi, manajemen produk, kategori produk, keranjang, pemesanan, dan data penjualan. Semua endpoint utama dilindungi oleh autentikasi JWT.

## Cara Menggunakan

1. **Kloning repositori dan install dependensi:**
    ```bash
    git clone <repo-url>
    cd pos-api
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

2. **Konfigurasi database** pada file `.env` sesuai kebutuhan Anda.

3. **Jalankan migrasi:**
    ```bash
    php artisan migrate
    ```

4. **Jalankan server lokal:**
    ```bash
    php artisan serve
    ```

## Autentikasi

- Register: `POST /api/auth/register`
- Login: `POST /api/auth/login`
- Logout: `POST /api/auth/logout` _(butuh token)_
- Refresh Token: `POST /api/auth/refresh` _(butuh token)_
- User Profile: `GET /api/auth/user-profile` _(butuh token)_

## Manajemen User (Admin)

- Lihat semua user: `GET /api/users`
- Lihat detail user: `GET /api/users/{id}`
- Tambah user: `POST /api/users`

## Manajemen Produk

- Lihat semua produk: `GET /api/products`
- Lihat detail produk: `GET /api/products/{id}`
- Tambah produk: `POST /api/products`
- Update produk: `PUT /api/products/{id}`
- Hapus produk: `DELETE /api/products/{id}`

## Manajemen Kategori Produk

- Lihat semua kategori: `GET /api/categories`
- Lihat detail kategori: `GET /api/categories/{id}`
- Tambah kategori: `POST /api/categories`
- Update kategori: `PUT /api/categories/{id}`

## Keranjang

- Lihat isi keranjang: `GET /api/cart`
- Tambah ke keranjang: `POST /api/cart/add`

## Pemesanan

- Lihat semua pesanan: `GET /api/orders`
- Lihat detail pesanan: `GET /api/orders/{id}`
- Buat pesanan: `POST /api/orders`

## Data Penjualan (Admin)

- Lihat data penjualan: `GET /api/sales`
- Lihat produk terlaris: `GET /api/top-products`

> Semua endpoint (kecuali register & login) membutuhkan autentikasi token JWT.

Untuk dokumentasi lebih lanjut, silakan lihat kode pada masing-masing controller atau gunakan tools seperti Postman untuk eksplorasi endpoint.