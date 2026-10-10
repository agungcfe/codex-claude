<?php

/** Escape output HTML untuk mencegah XSS. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function pull_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $flash;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(419);
        exit('Token CSRF tidak valid. Silakan muat ulang halaman.');
    }
}

function rupiah(float|int|string $amount): string
{
    return 'Rp ' . number_format((float) $amount, 0, ',', '.');
}

function abort_404(): never
{
    http_response_code(404);
    $title = 'Tidak ditemukan';
    require __DIR__ . '/../views/header.php';
    echo '<div class="card"><h2>404 - Produk tidak ditemukan</h2><p><a class="btn" href="index.php">Kembali ke daftar</a></p></div>';
    require __DIR__ . '/../views/footer.php';
    exit;
}

/**
 * Ambil & validasi input form produk.
 *
 * @return array{0: array, 1: array<string, string>} [data, errors]
 */
function validate_product(array $input, ProductRepository $repo, ?int $exceptId = null): array
{
    $data = [
        'sku'         => trim((string) ($input['sku'] ?? '')),
        'name'        => trim((string) ($input['name'] ?? '')),
        'category'    => trim((string) ($input['category'] ?? '')),
        'price'       => trim((string) ($input['price'] ?? '')),
        'stock'       => trim((string) ($input['stock'] ?? '')),
        'description' => trim((string) ($input['description'] ?? '')),
    ];
    $errors = [];

    if ($data['sku'] === '') {
        $errors['sku'] = 'SKU wajib diisi.';
    } elseif (!preg_match('/^[A-Za-z0-9\-_]{1,50}$/', $data['sku'])) {
        $errors['sku'] = 'SKU hanya boleh huruf, angka, "-" atau "_" (maks. 50 karakter).';
    } elseif ($repo->skuExists($data['sku'], $exceptId)) {
        $errors['sku'] = 'SKU sudah digunakan produk lain.';
    }

    if ($data['name'] === '') {
        $errors['name'] = 'Nama produk wajib diisi.';
    } elseif (mb_strlen($data['name']) > 150) {
        $errors['name'] = 'Nama produk maksimal 150 karakter.';
    }

    if (mb_strlen($data['category']) > 100) {
        $errors['category'] = 'Kategori maksimal 100 karakter.';
    }

    if ($data['price'] === '' || !is_numeric($data['price']) || (float) $data['price'] < 0) {
        $errors['price'] = 'Harga harus berupa angka dan tidak boleh negatif.';
    }

    if ($data['stock'] === '' || filter_var($data['stock'], FILTER_VALIDATE_INT) === false || (int) $data['stock'] < 0) {
        $errors['stock'] = 'Stok harus berupa bilangan bulat dan tidak boleh negatif.';
    }

    if (!$errors) {
        $data['price'] = (float) $data['price'];
        $data['stock'] = (int) $data['stock'];
    }

    return [$data, $errors];
}
