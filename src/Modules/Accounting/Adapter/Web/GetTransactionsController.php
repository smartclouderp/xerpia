<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetTransactions;

class GetTransactionsController
{
    private GetTransactions $getTransactions;

    public function __construct(GetTransactions $getTransactions)
    {
        $this->getTransactions = $getTransactions;
    }

    public function get(?string $dateFrom = null, ?string $dateTo = null, ?int $accountId = null, ?int $thirdPartyId = null): array
    {
        $txs = $this->getTransactions->execute($dateFrom, $dateTo, $accountId, $thirdPartyId);
        $data = array_map(function($line) {
            return [
                'id' => $line->getId(),
                'journal_entry_id' => $line->getJournalEntryId(),
                'account_id' => $line->getAccountId(),
                'debit' => $line->getDebit(),
                'credit' => $line->getCredit(),
                'description' => $line->getDescription(),
                'date' => $line->getDate(),
            ];
        }, $txs);
        return [
            'status' => 200,
            'body' => ['data' => $data]
        ];
    }
}
