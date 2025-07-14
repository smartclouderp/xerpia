<?php
namespace Xerpia\Modules\Provider\Domain\Entity;

class Provider
{
    private int $id;
    private string $businessName;
    private string $taxId;
    private string $address;
    private string $contactName;
    private string $contactEmail;
    private string $contactPhone;

    public function __construct(
        int $id,
        string $businessName,
        string $taxId,
        string $address,
        string $contactName,
        string $contactEmail,
        string $contactPhone
    ) {
        $this->id = $id;
        $this->businessName = $businessName;
        $this->taxId = $taxId;
        $this->address = $address;
        $this->contactName = $contactName;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
    }

    public function getId(): int { return $this->id; }
    public function getBusinessName(): string { return $this->businessName; }
    public function getTaxId(): string { return $this->taxId; }
    public function getAddress(): string { return $this->address; }
    public function getContactName(): string { return $this->contactName; }
    public function getContactEmail(): string { return $this->contactEmail; }
    public function getContactPhone(): string { return $this->contactPhone; }
}
