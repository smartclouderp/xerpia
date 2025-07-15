<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetJournalEntryById;

class GetJournalEntryByIdController
{
    private GetJournalEntryById $getJournalEntryById;

    public function __construct(GetJournalEntryById $getJournalEntryById)
    {
        $this->getJournalEntryById = $getJournalEntryById;
    }

    public function get(int $id): array
    {
        $entry = $this->getJournalEntryById->execute($id);
        if ($entry) {
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
                'status' => 200,
                'body' => [
                    'id' => $entry->getId(),
                    'date' => $entry->getDate(),
                    'description' => $entry->getDescription(),
                    'third_party_id' => $entry->getThirdPartyId(),
                    'lines' => $lines
                ]
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Comprobante no encontrado']
        ];
    }
}
