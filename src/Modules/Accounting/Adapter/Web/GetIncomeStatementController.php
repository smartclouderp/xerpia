<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetIncomeStatement;

class GetIncomeStatementController
{
    private GetIncomeStatement $useCase;

    public function __construct(GetIncomeStatement $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke($request)
    {
        $dateFrom = $request['dateFrom'] ?? null;
        $dateTo = $request['dateTo'] ?? null;
        $result = $this->useCase->execute($dateFrom, $dateTo);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
