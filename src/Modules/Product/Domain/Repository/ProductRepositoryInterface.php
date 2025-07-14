<?php
namespace Xerpia\Modules\Product\Domain\Repository;

use Xerpia\Modules\Product\Domain\Entity\Product;

interface ProductRepositoryInterface {
    public function save(Product $product): void;
    public function findById(int $id): ?Product;
    public function findAll(): array;
}
