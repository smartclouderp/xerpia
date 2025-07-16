<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetAccountMovementsReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el informe de movimientos por cuenta
     * @param int $account_id
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array
     */
    public function get($account_id, $date_from = null, $date_to = null)
    {
        $sql = 'SELECT * FROM transactions WHERE account_id = ?';
        $params = [$account_id];
        if ($date_from) {
            $sql .= ' AND date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' ORDER BY date ASC';
        $stmt = $this->transactionRepository->getPdo()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return [
            'status' => 200,
            'body' => $result
        ];
    }
}
