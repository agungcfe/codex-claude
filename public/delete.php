<?php

require __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method tidak diizinkan.');
}

verify_csrf();

$product = $products->find((int) ($_POST['id'] ?? 0)) ?? abort_404();
$products->delete((int) $product['id']);

flash('success', 'Produk "' . $product['name'] . '" berhasil dihapus.');
redirect('index.php');
