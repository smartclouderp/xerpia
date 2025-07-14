<?php
namespace Xerpia\Modules\Product\Adapter\Web\Dto;

class RegisterProductDto
{
    public string $name;
    public float $price;
    public int $stock;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->price = isset($data['price']) ? (float)$data['price'] : 0.0;
        $this->stock = isset($data['stock']) ? (int)$data['stock'] : 0;
    }

    public function isValid(): array
    {
        $errors = [];
        if (empty($this->name)) {
            $errors[] = 'El nombre del producto es requerido.';
        }
        if ($this->price <= 0) {
            $errors[] = 'El precio debe ser mayor a 0.';
        }
        if ($this->stock < 0) {
            $errors[] = 'El stock no puede ser negativo.';
        }
        return $errors;
    }
}
