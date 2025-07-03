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

- Lihat semua user: `GET /api/users` _(butuh token)_
- Lihat detail user: `GET /api/users/{id}` _(butuh token)_
- Tambah user: `POST /api/users`_(butuh token)_

## Manajemen Produk

- Lihat semua produk: `GET /api/products`_(butuh token)_
- Lihat detail produk: `GET /api/products/{id}`_(butuh token)_
- Tambah produk: `POST /api/products`_(butuh token)_
- Update produk: `PUT /api/products/{id}`_(butuh token)_
- Hapus produk: `DELETE /api/products/{id}`_(butuh token)_

## Manajemen Kategori Produk

- Lihat semua kategori: `GET /api/categories`_(butuh token)_
- Lihat detail kategori: `GET /api/categories/{id}`_(butuh token)_
- Tambah kategori: `POST /api/categories`_(butuh token)_
- Update kategori: `PUT /api/categories/{id}`_(butuh token)_

## Keranjang

- Lihat isi keranjang: `GET /api/cart`_(butuh token)_
- Tambah ke keranjang: `POST /api/cart/add`_(butuh token)_

## Documentasi API
> Untuk documentasi API, Anda dapat _localhost/api/documentation_


> Semua endpoint (kecuali register & login) membutuhkan autentikasi token JWT.

Untuk dokumentasi lebih lanjut, silakan lihat kode pada masing-masing controller atau gunakan tools seperti Postman untuk eksplorasi endpoint.
