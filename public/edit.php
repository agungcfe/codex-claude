<?php

require __DIR__ . '/../src/bootstrap.php';

$id      = (int) ($_GET['id'] ?? 0);
$product = $products->find($id) ?? abort_404();
$data    = $product;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    [$data, $errors] = validate_product($_POST, $products, $id);

    if (!$errors) {
        $products->update($id, $data);
        flash('success', 'Produk "' . $data['name'] . '" berhasil diperbarui.');
        redirect('show.php?id=' . $id);
    }
}

$title       = 'Edit Produk';
$action      = 'edit.php?id=' . $id;
$submitLabel = 'Perbarui';
require __DIR__ . '/../views/header.php';
?>
<div class="card">
    <h1>Edit Produk</h1>
    <?php require __DIR__ . '/../views/form.php'; ?>
</div>
<?php require __DIR__ . '/../views/footer.php'; ?>
