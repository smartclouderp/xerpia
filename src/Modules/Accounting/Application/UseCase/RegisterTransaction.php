<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\Transaction;
use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class RegisterTransaction {
    private TransactionRepositoryInterface $repository;

    public function __construct(TransactionRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(float $amount, string $description, \DateTime $date): void {
        $transaction = new Transaction($amount, $description, $date);
        $this->repository->save($transaction);
    }
}
