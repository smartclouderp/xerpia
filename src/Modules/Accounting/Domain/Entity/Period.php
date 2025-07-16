<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class Period
{
    private int $id;
    private string $name;
    private string $dateFrom;
    private string $dateTo;
    private string $status; // open | closed

    public function __construct(int $id, string $name, string $dateFrom, string $dateTo, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->status = $status;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDateFrom(): string { return $this->dateFrom; }
    public function getDateTo(): string { return $this->dateTo; }
    public function getStatus(): string { return $this->status; }
    public function isOpen(): bool { return $this->status === 'open'; }
}
