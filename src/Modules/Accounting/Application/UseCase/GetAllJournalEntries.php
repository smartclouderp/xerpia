<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryRepositoryInterface;

class GetAllJournalEntries
{
    private JournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(JournalEntryRepositoryInterface $journalEntryRepository)
    {
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function execute(): array
    {
        return $this->journalEntryRepository->findAll();
    }
}
