<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\Transaction;
use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;
use Xerpia\Modules\Accounting\Application\UseCase\ValidateDateInOpenPeriod;

class RegisterTransaction {
    private TransactionRepositoryInterface $repository;
    private ValidateDateInOpenPeriod $validateDateInOpenPeriod;

    public function __construct(TransactionRepositoryInterface $repository, ValidateDateInOpenPeriod $validateDateInOpenPeriod) {
        $this->repository = $repository;
        $this->validateDateInOpenPeriod = $validateDateInOpenPeriod;
    }

    /**
     * @throws \Exception Si la fecha no está en un periodo abierto
     */
    public function execute(float $amount, string $description, \DateTime $date): void {
        $dateStr = $date->format('Y-m-d');
        if (!$this->validateDateInOpenPeriod->execute($dateStr)) {
            throw new \Exception('La fecha de la transacción no está en un periodo contable abierto.');
        }
        $transaction = new Transaction($amount, $description, $date);
        $this->repository->save($transaction);
    }
}
