<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetPeriodCloseReportController
{
    private $periodRepository;
    private $transactionRepository;

    public function __construct(PeriodRepositoryInterface $periodRepository, TransactionRepositoryInterface $transactionRepository)
    {
        $this->periodRepository = $periodRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Informe de cierre de periodo contable
     * @param int $period_id
     * @return array
     */
    public function get($period_id)
    {
        $period = $this->periodRepository->findById($period_id);
        if (!$period) {
            return [
                'status' => 404,
                'body' => ['error' => 'Periodo no encontrado']
            ];
        }
        $transactions = $this->transactionRepository->findAllByDateRange($period['date_from'], $period['date_to']);
        $total = 0;
        foreach ($transactions as $tx) {
            $total += $tx['amount'];
        }
        return [
            'status' => 200,
            'body' => [
                'period' => $period,
                'total_movimientos' => count($transactions),
                'total' => $total,
                'movimientos' => $transactions
            ]
        ];
    }
}
