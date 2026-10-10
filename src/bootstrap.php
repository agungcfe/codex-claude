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
    $message = 'Gagal terhubung ke database: ' . $ex->getMessage();

    $driver = $config['db']['driver'];
    if (!in_array($driver, PDO::getAvailableDrivers(), true)) {
        $message .= sprintf(
            "\n\nEkstensi pdo_%s belum aktif di PHP ini (%s).\n"
            . "Driver yang tersedia: %s.\n"
            . "Aktifkan baris \"extension=pdo_%s\" di php.ini (%s), lalu restart Apache.",
            $driver,
            PHP_VERSION,
            implode(', ', PDO::getAvailableDrivers()) ?: '(tidak ada)',
            $driver,
            php_ini_loaded_file() ?: 'php.ini tidak ditemukan'
        );
    }

    exit('<pre>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</pre>');
}

$products = new ProductRepository($pdo);
