<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Entity\JournalEntry;

class GetJournalEntryById
{
    private JournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(JournalEntryRepositoryInterface $journalEntryRepository)
    {
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function execute(int $id): ?JournalEntry
    {
        return $this->journalEntryRepository->findById($id);
    }
}
