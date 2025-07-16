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
        // Si el primer parámetro es un array (request), extraer los valores
        if (is_array($account_id)) {
            $req = $account_id;
            // Permitir account_id tanto en query string como en array
            if (isset($req['account_id'])) {
                $account_id = (int)$req['account_id'];
            } elseif (isset($_GET['account_id'])) {
                $account_id = (int)$_GET['account_id'];
            } else {
                $account_id = 0;
            }
            $date_from = $req['date_from'] ?? ($_GET['date_from'] ?? null);
            $date_to = $req['date_to'] ?? ($_GET['date_to'] ?? null);
        } else {
            // Si viene directo por query string
            if (isset($_GET['account_id'])) {
                $account_id = (int)$_GET['account_id'];
            }
            if (isset($_GET['date_from'])) {
                $date_from = $_GET['date_from'];
            }
            if (isset($_GET['date_to'])) {
                $date_to = $_GET['date_to'];
            }
        }
        $sql = 'SELECT t.id, t.amount, t.description, t.date, a.name AS cuenta, tp.name AS tercero
                FROM transactions t
                INNER JOIN accounts a ON t.account_id = a.id
                LEFT JOIN third_parties tp ON t.third_party_id = tp.id
                WHERE t.account_id = ?';
        $params = [$account_id];
        if ($date_from) {
            $sql .= ' AND t.date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND t.date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' ORDER BY t.date ASC';
        // Depuración: mostrar la consulta y los parámetros
        error_log('AccountMovementsReportController SQL: ' . $sql);
        error_log('AccountMovementsReportController Params: ' . print_r($params, true));
        $stmt = $this->transactionRepository->getPdo()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        error_log('AccountMovementsReportController $result: ' . print_r($result, true));
        $formatted = [];
        foreach ($result as $row) {
            $formatted[] = [
                'ID' => $row['id'],
                'Monto' => $row['amount'],
                'Descripción' => $row['description'],
                'Fecha' => $row['date'],
                'Cuenta' => $row['cuenta'],
                'Tercero' => $row['tercero']
            ];
        }
        return [
            'status' => 200,
            'body' => [
                'encabezado' => ['ID','Monto','Descripción','Fecha','Cuenta','Tercero'],
                'datos' => $formatted
            ]
        ];
    }
}
