<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class ThirdParty
{
    private int $id;
    private string $name;
    private ?string $document;
    private ?string $email;
    private ?string $phone;

    public function __construct(int $id, string $name, ?string $document = null, ?string $email = null, ?string $phone = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDocument(): ?string { return $this->document; }
    public function getEmail(): ?string { return $this->email; }
    public function getPhone(): ?string { return $this->phone; }
}
