<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\Transaction;

interface TransactionRepositoryInterface {
    public function save(Transaction $transaction): void;
    public function findById(int $id): ?Transaction;
    public function findAll(): array;
}
