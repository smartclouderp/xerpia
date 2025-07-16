<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetCashFlowReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el informe de flujo de efectivo
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array
     */
    public function get($date_from = null, $date_to = null)
    {
        // Supongamos que las cuentas de tipo 'banco' o 'caja' tienen account_id específico
        $sql = "SELECT account_id, SUM(amount) as flujo FROM transactions WHERE account_id IN (SELECT id FROM accounts WHERE type IN ('bank','cash'))";
        $params = [];
        if ($date_from) {
            $sql .= ' AND date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' GROUP BY account_id';
        $stmt = $this->transactionRepository->getPdo()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return [
            'status' => 200,
            'body' => $result
        ];
    }
}
