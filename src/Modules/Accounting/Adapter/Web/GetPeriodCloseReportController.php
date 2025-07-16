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
        if (is_array($period_id)) {
            $period_id = isset($period_id['period_id']) ? (int)$period_id['period_id'] : 0;
        }
        $period = $this->periodRepository->findById($period_id);
        if (!$period) {
            return [
                'status' => 404,
                'body' => ['error' => 'Periodo no encontrado']
            ];
        }
        $transactions = $this->transactionRepository->findAllByDateRange($period->getDateFrom(), $period->getDateTo());
        $total = 0;
        $formatted = [];
        foreach ($transactions as $tx) {
            $total += $tx['amount'];
            $formatted[] = [
                'ID' => $tx['id'],
                'Monto' => $tx['amount'],
                'Descripción' => $tx['description'],
                'Fecha' => $tx['date'],
                'Cuenta' => $tx['account_id'],
                'Tercero' => $tx['third_party_id']
            ];
        }
        return [
            'status' => 200,
            'body' => [
                'period' => [
                    'id' => $period->getId(),
                    'name' => $period->getName(),
                    'date_from' => $period->getDateFrom(),
                    'date_to' => $period->getDateTo(),
                    'status' => $period->getStatus()
                ],
                'total_movimientos' => count($transactions),
                'total' => $total,
                'encabezado' => ['ID','Monto','Descripción','Fecha','Cuenta','Tercero'],
                'movimientos' => $formatted
            ]
        ];
    }
}
