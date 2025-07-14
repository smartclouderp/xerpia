<?php
namespace Xerpia\Modules\Product\Adapter\Web;

use Xerpia\Modules\Product\Application\UseCase\RegisterProduct;
use Xerpia\Modules\Product\Adapter\Web\Dto\RegisterProductDto;

class ProductController {
    private RegisterProduct $registerProduct;

    public function __construct(RegisterProduct $registerProduct) {
        $this->registerProduct = $registerProduct;
    }

    public function register(array $data): array {
        $dto = new RegisterProductDto($data);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $this->registerProduct->execute($dto->name, $dto->price, $dto->stock);
        return [
            'status' => 201,
            'body' => ['message' => 'Producto registrado']
        ];
    }
}
