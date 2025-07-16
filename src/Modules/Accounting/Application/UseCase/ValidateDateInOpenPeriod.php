<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;

class ValidateDateInOpenPeriod
{
    private PeriodRepositoryInterface $periodRepository;
    public function __construct(PeriodRepositoryInterface $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }
    public function execute(string $date): bool
    {
        $period = $this->periodRepository->findOpenByDate($date);
        return $period !== null;
    }
}
