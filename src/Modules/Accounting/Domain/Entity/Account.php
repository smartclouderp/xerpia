<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class Account
{
    private int $id;
    private string $code;
    private string $name;
    private ?int $parentId;
    private string $type; // asset, liability, equity, income, expense

    public function __construct(int $id, string $code, string $name, ?int $parentId, string $type)
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->type = $type;
    }

    public function getId(): int { return $this->id; }
    public function getCode(): string { return $this->code; }
    public function getName(): string { return $this->name; }
    public function getParentId(): ?int { return $this->parentId; }
    public function getType(): string { return $this->type; }
}
