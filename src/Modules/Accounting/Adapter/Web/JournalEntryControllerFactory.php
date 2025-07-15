<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbJournalEntryRepository;
use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbJournalEntryLineRepository;
use Xerpia\Modules\Accounting\Application\UseCase\RegisterJournalEntry;
use Xerpia\Modules\Accounting\Application\UseCase\DeleteJournalEntry;
use Xerpia\Modules\Accounting\Application\UseCase\GetJournalEntryById;
use Xerpia\Modules\Accounting\Application\UseCase\GetAllJournalEntries;

class JournalEntryControllerFactory
{
    public static function create($pdo)
    {
        $lineRepo = new MariaDbJournalEntryLineRepository($pdo);
        $entryRepo = new MariaDbJournalEntryRepository($pdo, $lineRepo);
        return [
            'registerJournalEntryController' => new RegisterJournalEntryController(new RegisterJournalEntry($entryRepo)),
            'deleteJournalEntryController' => new DeleteJournalEntryController(new DeleteJournalEntry($entryRepo)),
            'getJournalEntryByIdController' => new GetJournalEntryByIdController(new GetJournalEntryById($entryRepo)),
            'getAllJournalEntriesController' => new GetAllJournalEntriesController(new GetAllJournalEntries($entryRepo)),
        ];
    }
}
