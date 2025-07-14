<?php
namespace Xerpia\Modules\Provider\Adapter\Web\Dto;

class ProviderListQueryDto
{
    public int $page;
    public int $limit;
    public ?string $search;

    public function __construct(array $data)
    {
        $this->page = isset($data['page']) ? max(1, (int)$data['page']) : 1;
        $this->limit = isset($data['limit']) ? max(1, (int)$data['limit']) : 10;
        $this->search = isset($data['search']) ? trim($data['search']) : null;
    }

    public function isValid(): array
    {
        $errors = [];
        if ($this->page < 1) $errors[] = 'La página debe ser mayor o igual a 1.';
        if ($this->limit < 1) $errors[] = 'El límite debe ser mayor o igual a 1.';
        return $errors;
    }
}
