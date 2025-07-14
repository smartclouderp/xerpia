<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class Transaction {
    private int $id;
    private float $amount;
    private string $description;
    private \DateTime $date;

    public function __construct(float $amount, string $description, \DateTime $date) {
        $this->amount = $amount;
        $this->description = $description;
        $this->date = $date;
    }

    // Getters y setters
    public function getAmount(): float { return $this->amount; }
    public function getDescription(): string { return $this->description; }
    public function getDate(): \DateTime { return $this->date; }
}
