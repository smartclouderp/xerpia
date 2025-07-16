<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;

class ListPeriodsController
{
    private $periodRepository;

    public function __construct(PeriodRepositoryInterface $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    public function list()
    {
        $periods = $this->periodRepository->getAllPeriods();
        return [
            'status' => 200,
            'body' => $periods
        ];
    }
}
