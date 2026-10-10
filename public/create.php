<?php

require __DIR__ . '/../src/bootstrap.php';

$data   = ['sku' => '', 'name' => '', 'category' => '', 'price' => '', 'stock' => '0', 'description' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    [$data, $errors] = validate_product($_POST, $products);

    if (!$errors) {
        $id = $products->create($data);
        flash('success', 'Produk "' . $data['name'] . '" berhasil ditambahkan.');
        redirect('show.php?id=' . $id);
    }
}

$title       = 'Tambah Produk';
$action      = 'create.php';
$submitLabel = 'Simpan';
require __DIR__ . '/../views/header.php';
?>
<div class="card">
    <h1>Tambah Produk</h1>
    <?php require __DIR__ . '/../views/form.php'; ?>
</div>
<?php require __DIR__ . '/../views/footer.php'; ?>
