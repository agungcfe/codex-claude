<?php /** @var array $config */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($title ?? 'Produk') . ' | ' . ($config['app_name'] ?? 'Manajemen Produk')) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="container">
        <a class="brand" href="index.php"><?= e($config['app_name'] ?? 'Manajemen Produk') ?></a>
        <nav>
            <a href="index.php">Daftar Produk</a>
            <a class="btn btn-primary" href="create.php">+ Tambah Produk</a>
        </nav>
    </div>
</header>
<main class="container">
<?php if ($flash = pull_flash()): ?>
    <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>
