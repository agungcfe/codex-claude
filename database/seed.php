<?php
/**
 * Isi data contoh: php database/seed.php
 */
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../src/ProductRepository.php';

$config = require __DIR__ . '/../config/config.php';
$repo   = new ProductRepository(Database::connection($config['db']));

$samples = [
    ['sku' => 'ELK-001', 'name' => 'Mouse Wireless', 'category' => 'Elektronik', 'price' => 125000, 'stock' => 40, 'description' => 'Mouse wireless 2.4GHz dengan baterai tahan lama.'],
    ['sku' => 'ELK-002', 'name' => 'Keyboard Mekanikal', 'category' => 'Elektronik', 'price' => 650000, 'stock' => 8, 'description' => 'Keyboard mekanikal switch biru, lampu RGB.'],
    ['sku' => 'ATK-001', 'name' => 'Buku Tulis A5', 'category' => 'Alat Tulis', 'price' => 7500, 'stock' => 200, 'description' => 'Buku tulis 58 lembar.'],
    ['sku' => 'MKN-001', 'name' => 'Kopi Arabika 250g', 'category' => 'Makanan & Minuman', 'price' => 85000, 'stock' => 0, 'description' => 'Biji kopi arabika Gayo sangrai medium.'],
];

$added = 0;
foreach ($samples as $item) {
    if (!$repo->skuExists($item['sku'])) {
        $repo->create($item);
        $added++;
    }
}

echo "Seed selesai: {$added} produk ditambahkan." . PHP_EOL;
