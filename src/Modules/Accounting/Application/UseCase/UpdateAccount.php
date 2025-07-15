<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\Account;
use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;

class UpdateAccount
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(int $id, string $code, string $name, ?int $parentId, string $type): bool
    {
        $account = new Account($id, $code, $name, $parentId, $type);
        return $this->accountRepository->update($account);
    }
}
