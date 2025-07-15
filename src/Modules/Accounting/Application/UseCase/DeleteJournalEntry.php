<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryRepositoryInterface;

class DeleteJournalEntry
{
    private JournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(JournalEntryRepositoryInterface $journalEntryRepository)
    {
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function execute(int $id): bool
    {
        return $this->journalEntryRepository->delete($id);
    }
}
