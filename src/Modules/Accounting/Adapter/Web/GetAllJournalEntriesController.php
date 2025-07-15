<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetAllJournalEntries;

class GetAllJournalEntriesController
{
    private GetAllJournalEntries $getAllJournalEntries;

    public function __construct(GetAllJournalEntries $getAllJournalEntries)
    {
        $this->getAllJournalEntries = $getAllJournalEntries;
    }

    public function get(): array
    {
        $entries = $this->getAllJournalEntries->execute();
        $data = array_map(function($entry) {
            $lines = array_map(function($line) {
                return [
                    'id' => $line->getId(),
                    'account_id' => $line->getAccountId(),
                    'debit' => $line->getDebit(),
                    'credit' => $line->getCredit(),
                    'description' => $line->getDescription()
                ];
            }, $entry->getLines());
            return [
                'id' => $entry->getId(),
                'date' => $entry->getDate(),
                'description' => $entry->getDescription(),
                'third_party_id' => $entry->getThirdPartyId(),
                'lines' => $lines
            ];
        }, $entries);
        return [
            'status' => 200,
            'body' => ['data' => $data]
        ];
    }
}
