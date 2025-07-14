<?php
namespace Xerpia\Modules\Product\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Product\Domain\Entity\Product;

class MariaDbProductRepositoryExtended
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id');
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
