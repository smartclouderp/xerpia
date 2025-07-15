<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class JournalEntry
{
    private int $id;
    private string $date;
    private string $description;
    private int $thirdPartyId; // FK a ThirdParty
    private array $lines; // array de JournalEntryLine

    public function __construct(int $id, string $date, string $description, int $thirdPartyId, array $lines)
    {
        $this->id = $id;
        $this->date = $date;
        $this->description = $description;
        $this->thirdPartyId = $thirdPartyId;
        $this->lines = $lines;
    }

    public function getId(): int { return $this->id; }
    public function getDate(): string { return $this->date; }
    public function getDescription(): string { return $this->description; }
    public function getThirdPartyId(): int { return $this->thirdPartyId; }
    public function getLines(): array { return $this->lines; }
}
