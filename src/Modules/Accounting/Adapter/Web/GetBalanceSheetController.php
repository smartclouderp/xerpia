<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetBalanceSheet;

class GetBalanceSheetController
{
    private GetBalanceSheet $getBalanceSheet;

    public function __construct(GetBalanceSheet $getBalanceSheet)
    {
        $this->getBalanceSheet = $getBalanceSheet;
    }

    public function get(?string $dateTo = null): array
    {
        $balances = $this->getBalanceSheet->execute($dateTo);
        return [
            'status' => 200,
            'body' => ['data' => $balances]
        ];
    }
}
