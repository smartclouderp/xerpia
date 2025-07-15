<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\Account;
use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;

class RegisterAccount
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(string $code, string $name, ?int $parentId, string $type): bool
    {
        $account = new Account(0, $code, $name, $parentId, $type);
        return $this->accountRepository->create($account);
    }
}
