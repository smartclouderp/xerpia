<?php
namespace Xerpia\Modules\Provider\Adapter\Web\Dto;

class RegisterProviderDto
{
    public string $businessName;
    public string $taxId;
    public string $address;
    public string $contactName;
    public string $contactEmail;
    public string $contactPhone;

    public function __construct(array $data)
    {
        $this->businessName = $data['businessName'] ?? '';
        $this->taxId = $data['taxId'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->contactName = $data['contactName'] ?? '';
        $this->contactEmail = $data['contactEmail'] ?? '';
        $this->contactPhone = $data['contactPhone'] ?? '';
    }

    public function isValid(): array
    {
        $errors = [];
        if (empty($this->businessName)) $errors[] = 'La razón social es requerida.';
        if (empty($this->taxId)) $errors[] = 'El RFC/NIT es requerido.';
        if (empty($this->address)) $errors[] = 'La dirección es requerida.';
        if (empty($this->contactName)) $errors[] = 'El nombre de contacto es requerido.';
        if (empty($this->contactEmail)) $errors[] = 'El email de contacto es requerido.';
        if (empty($this->contactPhone)) $errors[] = 'El teléfono de contacto es requerido.';
        return $errors;
    }
}
