<?php
namespace Xerpia\Modules\Accounting\Domain\Entity;

class JournalEntryLine
{
    private int $id;
    private int $journalEntryId; // FK a JournalEntry
    private int $accountId; // FK a Account
    private float $debit;
    private float $credit;
    private ?string $description;
    private ?string $date;

    public function __construct(int $id, int $journalEntryId, int $accountId, float $debit, float $credit, ?string $description = null, ?string $date = null)
    {
        $this->id = $id;
        $this->journalEntryId = $journalEntryId;
        $this->accountId = $accountId;
        $this->debit = $debit;
        $this->credit = $credit;
        $this->description = $description;
        $this->date = $date;
    }

    public function getId(): int { return $this->id; }
    public function getJournalEntryId(): int { return $this->journalEntryId; }
    public function getAccountId(): int { return $this->accountId; }
    public function getDebit(): float { return $this->debit; }
    public function getCredit(): float { return $this->credit; }
    public function getDescription(): ?string { return $this->description; }
    public function getDate(): ?string { return $this->date; }
}
