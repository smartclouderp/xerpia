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
        return [
            'status' => 200,
            'body' => ['data' => $txs]
        ];
    }
}
