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

    public function get(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $result = $this->useCase->execute($dateFrom, $dateTo);
        return [
            'status' => 200,
            'body' => $result
        ];
    }
}
