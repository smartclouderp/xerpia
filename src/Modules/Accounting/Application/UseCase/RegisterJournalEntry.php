<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\JournalEntry;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryRepositoryInterface;

class RegisterJournalEntry
{
    private JournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(JournalEntryRepositoryInterface $journalEntryRepository)
    {
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function execute(string $date, string $description, int $thirdPartyId, array $lines): bool
    {
        $entry = new JournalEntry(0, $date, $description, $thirdPartyId, $lines);
        return $this->journalEntryRepository->create($entry);
    }
}
