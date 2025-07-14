<?php
namespace Xerpia\Modules\Product\Infrastructure\Persistence;

use Xerpia\Modules\Product\Domain\Entity\Product;
use Xerpia\Modules\Product\Domain\Repository\ProductRepositoryInterface;
use PDO;

class MariaDbProductRepository implements ProductRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function save(Product $product): void {
        $stmt = $this->pdo->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
        $stmt->execute([
            $product->getName(),
            $product->getPrice(),
            $product->getStock()
        ]);
    }

    public function findById(int $id): ?Product {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Product($row['name'], $row['price'], $row['stock']);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = new Product($row['name'], $row['price'], $row['stock']);
        }
        return $products;
    }
}
