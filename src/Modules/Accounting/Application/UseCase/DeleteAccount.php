<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;

class DeleteAccount
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(int $id): bool
    {
        return $this->accountRepository->delete($id);
    }
}
