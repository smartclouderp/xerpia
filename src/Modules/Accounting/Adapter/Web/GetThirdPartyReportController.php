<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetThirdPartyReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el informe de movimientos y saldo por tercero
     * @param int $third_party_id
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array
     */
    public function get($third_party_id, $date_from = null, $date_to = null)
    {
        $transactions = $this->transactionRepository->findByThirdPartyAndDateRange($third_party_id, $date_from, $date_to);
        $saldo = 0;
        foreach ($transactions as $tx) {
            $saldo += $tx['amount'];
        }
        return [
            'status' => 200,
            'body' => [
                'third_party_id' => $third_party_id,
                'saldo' => $saldo,
                'movimientos' => $transactions
            ]
        ];
    }
}
