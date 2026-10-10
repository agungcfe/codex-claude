<?php

final class ProductRepository
{
    public function __construct(private PDO $db)
    {
    }

    /** @return array{items: array<int, array>, total: int} */
    public function paginate(string $search, int $page, int $perPage): array
    {
        $where  = '';
        $params = [];
        if ($search !== '') {
            $where = 'WHERE name LIKE :q OR sku LIKE :q OR category LIKE :q';
            $params[':q'] = '%' . $search . '%';
        }

        $count = $this->db->prepare("SELECT COUNT(*) FROM products $where");
        $count->execute($params);
        $total = (int) $count->fetchColumn();

        $stmt = $this->db->prepare(
            "SELECT * FROM products $where ORDER BY id DESC LIMIT :limit OFFSET :offset"
        );
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($page - 1) * $perPage, PDO::PARAM_INT);
        $stmt->execute();

        return ['items' => $stmt->fetchAll(), 'total' => $total];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function skuExists(string $sku, ?int $exceptId = null): bool
    {
        $sql    = 'SELECT COUNT(*) FROM products WHERE sku = :sku';
        $params = [':sku' => $sku];
        if ($exceptId !== null) {
            $sql .= ' AND id <> :id';
            $params[':id'] = $exceptId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(array $data): int
    {
        $now  = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare(
            'INSERT INTO products (sku, name, category, price, stock, description, created_at, updated_at)
             VALUES (:sku, :name, :category, :price, :stock, :description, :created_at, :updated_at)'
        );
        $stmt->execute([
            ':sku'         => $data['sku'],
            ':name'        => $data['name'],
            ':category'    => $data['category'],
            ':price'       => $data['price'],
            ':stock'       => $data['stock'],
            ':description' => $data['description'],
            ':created_at'  => $now,
            ':updated_at'  => $now,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products
                SET sku = :sku, name = :name, category = :category, price = :price,
                    stock = :stock, description = :description, updated_at = :updated_at
              WHERE id = :id'
        );
        $stmt->execute([
            ':sku'         => $data['sku'],
            ':name'        => $data['name'],
            ':category'    => $data['category'],
            ':price'       => $data['price'],
            ':stock'       => $data['stock'],
            ':description' => $data['description'],
            ':updated_at'  => date('Y-m-d H:i:s'),
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
