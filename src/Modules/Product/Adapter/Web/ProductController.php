<?php
namespace Xerpia\Modules\Product\Adapter\Web;

use Xerpia\Modules\Product\Application\UseCase\RegisterProduct;

class ProductController {
    private RegisterProduct $registerProduct;

    public function __construct(RegisterProduct $registerProduct) {
        $this->registerProduct = $registerProduct;
    }

    public function register(array $data): void {
        $name = $data['name'];
        $price = $data['price'];
        $stock = $data['stock'];
        $this->registerProduct->execute($name, $price, $stock);
        echo "Producto registrado";
    }
}
