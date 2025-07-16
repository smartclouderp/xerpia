<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetAccountsPayableReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el informe de cuentas por pagar
     * @param string|null $date_to
     * @return array
     */
    public function get($date_to = null)
    {
        // Supongamos que las transacciones negativas son por pagar y tienen un third_party_id (proveedor)
        $sql = 'SELECT third_party_id, SUM(amount) as saldo FROM transactions WHERE amount < 0';
        $params = [];
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' GROUP BY third_party_id HAVING saldo < 0';
        $stmt = $this->transactionRepository->getPdo()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return [
            'status' => 200,
            'body' => $result
        ];
    }
}
