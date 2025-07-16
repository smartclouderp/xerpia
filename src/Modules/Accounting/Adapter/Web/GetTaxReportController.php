<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetTaxReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el informe de impuestos (IVA, retenciones, etc.)
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array
     */
    public function get($date_from = null, $date_to = null)
    {
        // Supongamos que hay un campo 'tax_type' y 'tax_amount' en la tabla transactions
        $sql = 'SELECT tax_type, SUM(tax_amount) as total FROM transactions WHERE tax_type IS NOT NULL';
        $params = [];
        if ($date_from) {
            $sql .= ' AND date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' GROUP BY tax_type';
        $stmt = $this->transactionRepository->getPdo()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return [
            'status' => 200,
            'body' => $result
        ];
    }
}
