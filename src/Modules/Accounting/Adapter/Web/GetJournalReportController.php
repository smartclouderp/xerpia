<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class GetJournalReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Obtiene el libro diario entre dos fechas
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array
     */
    public function get($date_from = null, $date_to = null)
    {
        $transactions = $this->transactionRepository->findAllByDateRange($date_from, $date_to);
        return [
            'status' => 200,
            'body' => $transactions
        ];
    }
}
