<?php
namespace Xerpia\Modules\Product\Application\UseCase;

use Xerpia\Modules\Product\Domain\Entity\Product;
use Xerpia\Modules\Product\Domain\Repository\ProductRepositoryInterface;

class RegisterProduct {
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(string $name, float $price, int $stock): void {
        $product = new Product($name, $price, $stock);
        $this->repository->save($product);
    }
}
