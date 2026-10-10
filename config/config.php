<?php

/**
 * Konfigurasi aplikasi.
 *
 * driver: "sqlite" (default, tanpa setup) atau "mysql".
 * Nilai dapat ditimpa dengan environment variable (DB_DRIVER, DB_HOST, dst).
 */
return [
    'app_name' => 'Manajemen Produk',
    'db' => [
        'driver'   => getenv('DB_DRIVER') ?: 'sqlite',
        'sqlite'   => getenv('DB_PATH') ?: __DIR__ . '/../database/app.sqlite',
        'host'     => getenv('DB_HOST') ?: '127.0.0.1',
        'port'     => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_NAME') ?: 'crud_produk',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
    ],
    'per_page' => 10,
];
