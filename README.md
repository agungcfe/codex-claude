# Manajemen Produk — CRUD PHP Native

Aplikasi web sederhana untuk mengelola data **produk** (Create, Read, Update, Delete)
menggunakan **PHP native** (tanpa framework) dan **PDO**.

## Fitur

- Daftar produk dengan **pencarian** (nama / SKU / kategori) dan **paginasi**
- Tambah, lihat detail, edit, dan hapus produk
- Validasi input di sisi server (SKU unik, harga & stok tidak negatif, dll.)
- Keamanan dasar: prepared statement (anti SQL injection), escape output (anti XSS),
  token CSRF untuk semua form, hapus hanya via `POST`
- Flash message setelah aksi berhasil
- Mendukung **SQLite** (default, tanpa setup) dan **MySQL/MariaDB**

## Struktur Folder

```
config/config.php          Konfigurasi aplikasi & database
database/schema.mysql.sql  Skema tabel untuk MySQL
database/seed.php          Script data contoh
public/                    Document root (index, create, show, edit, delete)
public/assets/style.css    Styling
src/                       Koneksi DB, repository produk, helper, bootstrap
views/                     Template header, footer, dan form
```

## Kebutuhan

- PHP 8.1+ dengan ekstensi `pdo_sqlite` (default) atau `pdo_mysql`

## Menjalankan (SQLite — paling cepat)

```bash
php database/seed.php          # opsional: isi data contoh
php -S localhost:8000 -t public
```

Buka http://localhost:8000. File database dibuat otomatis di `database/app.sqlite`.

## Menggunakan MySQL

1. Import skema:
   ```bash
   mysql -u root -p < database/schema.mysql.sql
   ```
2. Ubah `config/config.php` (`driver` => `mysql`, isi host/user/password),
   atau gunakan environment variable:
   ```bash
   DB_DRIVER=mysql DB_HOST=127.0.0.1 DB_NAME=crud_produk DB_USER=root DB_PASS=secret \
     php -S localhost:8000 -t public
   ```

Jika memakai XAMPP/Laragon, letakkan proyek di `htdocs`/`www` lalu akses folder `public/`.
