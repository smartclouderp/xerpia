<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Entity\Account;

class GetAccountById
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(int $id): ?Account
    {
        return $this->accountRepository->findById($id);
    }
}
