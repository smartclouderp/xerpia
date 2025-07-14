<?php
namespace Xerpia\Modules\Provider\Adapter\Web\Dto;

class ProviderQueryDto
{
    public ?int $id;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
    }

    public function isValid(): array
    {
        $errors = [];
        if ($this->id !== null && $this->id <= 0) {
            $errors[] = 'El id debe ser mayor a 0.';
        }
        return $errors;
    }
}
