<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetGeneralLedger;

class GetGeneralLedgerController
{
    private GetGeneralLedger $getGeneralLedger;

    public function __construct(GetGeneralLedger $getGeneralLedger)
    {
        $this->getGeneralLedger = $getGeneralLedger;
    }

    public function get(?int $accountId = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $ledger = $this->getGeneralLedger->execute($accountId, $dateFrom, $dateTo);
        return [
            'status' => 200,
            'body' => ['data' => $ledger]
        ];
    }
}
