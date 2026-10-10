<?php
/**
 * Form produk bersama untuk create & edit.
 * @var array $data
 * @var array $errors
 * @var string $action
 * @var string $submitLabel
 */
$field = static fn(string $key): string => e($data[$key] ?? '');
$error = static fn(string $key): string => isset($errors[$key])
    ? '<small class="error">' . e($errors[$key]) . '</small>'
    : '';
?>
<form method="post" action="<?= e($action) ?>" class="form" novalidate>
    <?= csrf_field() ?>
    <div class="grid">
        <label>
            SKU <span class="req">*</span>
            <input type="text" name="sku" value="<?= $field('sku') ?>" maxlength="50" required
                   class="<?= isset($errors['sku']) ? 'invalid' : '' ?>">
            <?= $error('sku') ?>
        </label>
        <label>
            Nama Produk <span class="req">*</span>
            <input type="text" name="name" value="<?= $field('name') ?>" maxlength="150" required
                   class="<?= isset($errors['name']) ? 'invalid' : '' ?>">
            <?= $error('name') ?>
        </label>
        <label>
            Kategori
            <input type="text" name="category" value="<?= $field('category') ?>" maxlength="100"
                   class="<?= isset($errors['category']) ? 'invalid' : '' ?>">
            <?= $error('category') ?>
        </label>
        <label>
            Harga (Rp) <span class="req">*</span>
            <input type="number" name="price" value="<?= $field('price') ?>" min="0" step="0.01" required
                   class="<?= isset($errors['price']) ? 'invalid' : '' ?>">
            <?= $error('price') ?>
        </label>
        <label>
            Stok <span class="req">*</span>
            <input type="number" name="stock" value="<?= $field('stock') ?>" min="0" step="1" required
                   class="<?= isset($errors['stock']) ? 'invalid' : '' ?>">
            <?= $error('stock') ?>
        </label>
    </div>
    <label>
        Deskripsi
        <textarea name="description" rows="4"><?= $field('description') ?></textarea>
    </label>
    <div class="actions">
        <a class="btn" href="index.php">Batal</a>
        <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
    </div>
</form>
