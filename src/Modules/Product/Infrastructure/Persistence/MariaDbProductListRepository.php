<?php
namespace Xerpia\Modules\Product\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Product\Domain\Entity\Product;

class MariaDbProductListRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(array $filters = [], int $page = 1, int $limit = 10): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['name'])) {
            $where[] = 'name LIKE :name';
            $params['name'] = '%' . $filters['name'] . '%';
        }
        if (!empty($filters['min_price'])) {
            $where[] = 'price >= :min_price';
            $params['min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'price <= :max_price';
            $params['max_price'] = $filters['max_price'];
        }

        $sql = 'SELECT * FROM products';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' LIMIT :offset, :limit';

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':offset', ($page - 1) * $limit, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product($row['name'], $row['price'], $row['stock']);
        }
        return $products;
    }
}
