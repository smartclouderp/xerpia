<?php
namespace Xerpia\Modules\Product\Adapter\Web;

use Xerpia\Modules\Product\Adapter\Web\Dto\ProductListQueryDto;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductListRepository;

class ProductListController
{
    private MariaDbProductListRepository $repository;

    public function __construct(MariaDbProductListRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $request): array
    {
        $dto = new ProductListQueryDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $filters = [
            'name' => $dto->name,
            'min_price' => $dto->minPrice,
            'max_price' => $dto->maxPrice
        ];
        $products = $this->repository->findAll($filters, $dto->page, $dto->limit);
        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock()
            ];
        }
        return [
            'status' => 200,
            'body' => ['products' => $result]
        ];
    }
}
