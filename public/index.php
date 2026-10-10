<?php

require __DIR__ . '/../src/bootstrap.php';

$search  = trim((string) ($_GET['q'] ?? ''));
$page    = max(1, (int) ($_GET['page'] ?? 1));
$perPage = $config['per_page'];

$result     = $products->paginate($search, $page, $perPage);
$totalPages = max(1, (int) ceil($result['total'] / $perPage));

$title = 'Daftar Produk';
require __DIR__ . '/../views/header.php';
?>
<div class="card">
    <div class="card-head">
        <h1>Daftar Produk</h1>
        <form method="get" class="search">
            <input type="search" name="q" value="<?= e($search) ?>" placeholder="Cari nama, SKU, kategori...">
            <button class="btn" type="submit">Cari</button>
            <?php if ($search !== ''): ?>
                <a class="btn" href="index.php">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <p class="muted">Total: <?= $result['total'] ?> produk</p>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>SKU</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th class="num">Harga</th>
                <th class="num">Stok</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!$result['items']): ?>
                <tr><td colspan="7" class="empty">Belum ada produk<?= $search !== '' ? ' yang cocok dengan pencarian' : '' ?>.</td></tr>
            <?php endif; ?>
            <?php foreach ($result['items'] as $i => $p): ?>
                <tr>
                    <td><?= ($page - 1) * $perPage + $i + 1 ?></td>
                    <td><code><?= e($p['sku']) ?></code></td>
                    <td><?= e($p['name']) ?></td>
                    <td><?= e($p['category'] ?: '-') ?></td>
                    <td class="num"><?= rupiah($p['price']) ?></td>
                    <td class="num">
                        <span class="badge <?= (int) $p['stock'] === 0 ? 'badge-danger' : ((int) $p['stock'] < 10 ? 'badge-warn' : 'badge-ok') ?>">
                            <?= (int) $p['stock'] ?>
                        </span>
                    </td>
                    <td class="row-actions">
                        <a class="btn btn-sm" href="show.php?id=<?= (int) $p['id'] ?>">Detail</a>
                        <a class="btn btn-sm" href="edit.php?id=<?= (int) $p['id'] ?>">Edit</a>
                        <form method="post" action="delete.php"
                              onsubmit="return confirm('Hapus produk &quot;<?= e($p['name']) ?>&quot;?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php for ($n = 1; $n <= $totalPages; $n++): ?>
                <a class="<?= $n === $page ? 'active' : '' ?>"
                   href="?<?= e(http_build_query(['q' => $search, 'page' => $n])) ?>"><?= $n ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../views/footer.php'; ?>
