<?php

declare(strict_types=1);

session_start();
date_default_timezone_set('Asia/Jakarta');

require __DIR__ . '/Database.php';
require __DIR__ . '/ProductRepository.php';
require __DIR__ . '/helpers.php';

$config = require __DIR__ . '/../config/config.php';

try {
    $pdo = Database::connection($config['db']);
} catch (PDOException $ex) {
    http_response_code(500);
    exit('Gagal terhubung ke database: ' . htmlspecialchars($ex->getMessage(), ENT_QUOTES, 'UTF-8'));
}

$products = new ProductRepository($pdo);
