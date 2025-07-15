<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function findAll(): array;
    public function delete(int $id): bool;
    public function findById(int $id): ?Account;
    public function create(Account $account): bool;
    public function update(Account $account): bool;
}
