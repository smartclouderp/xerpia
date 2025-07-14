<?php
namespace Xerpia\Modules\Product\Adapter\Web\Dto;

class ProductListQueryDto
{
    public int $page;
    public int $limit;
    public ?string $name;
    public ?float $minPrice;
    public ?float $maxPrice;

    public function __construct(array $data)
    {
        $this->page = isset($data['page']) ? max(1, (int)$data['page']) : 1;
        $this->limit = isset($data['limit']) ? max(1, (int)$data['limit']) : 10;
        $this->name = isset($data['name']) ? trim($data['name']) : null;
        $this->minPrice = isset($data['min_price']) ? (float)$data['min_price'] : null;
        $this->maxPrice = isset($data['max_price']) ? (float)$data['max_price'] : null;
    }

    public function isValid(): array
    {
        $errors = [];
        if ($this->page < 1) $errors[] = 'La página debe ser mayor o igual a 1.';
        if ($this->limit < 1) $errors[] = 'El límite debe ser mayor o igual a 1.';
        if ($this->minPrice !== null && $this->minPrice < 0) $errors[] = 'El precio mínimo no puede ser negativo.';
        if ($this->maxPrice !== null && $this->maxPrice < 0) $errors[] = 'El precio máximo no puede ser negativo.';
        return $errors;
    }
}
