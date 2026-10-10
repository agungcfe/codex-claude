<?php

require __DIR__ . '/../src/bootstrap.php';

$product = $products->find((int) ($_GET['id'] ?? 0)) ?? abort_404();

$title = $product['name'];
require __DIR__ . '/../views/header.php';
?>
<div class="card">
    <div class="card-head">
        <h1><?= e($product['name']) ?></h1>
        <div class="row-actions">
            <a class="btn" href="edit.php?id=<?= (int) $product['id'] ?>">Edit</a>
            <form method="post" action="delete.php" onsubmit="return confirm('Hapus produk ini?');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
    <dl class="detail">
        <dt>SKU</dt><dd><code><?= e($product['sku']) ?></code></dd>
        <dt>Kategori</dt><dd><?= e($product['category'] ?: '-') ?></dd>
        <dt>Harga</dt><dd><?= rupiah($product['price']) ?></dd>
        <dt>Stok</dt><dd><?= (int) $product['stock'] ?></dd>
        <dt>Deskripsi</dt><dd><?= $product['description'] !== null && $product['description'] !== '' ? nl2br(e($product['description'])) : '-' ?></dd>
        <dt>Dibuat</dt><dd><?= e($product['created_at']) ?></dd>
        <dt>Diperbarui</dt><dd><?= e($product['updated_at']) ?></dd>
    </dl>
    <a class="btn" href="index.php">&larr; Kembali</a>
</div>
<?php require __DIR__ . '/../views/footer.php'; ?>
