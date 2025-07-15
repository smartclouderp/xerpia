<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class GetBalanceSheet
{
    private AccountRepositoryInterface $accountRepository;
    private JournalEntryLineRepositoryInterface $lineRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, JournalEntryLineRepositoryInterface $lineRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->lineRepository = $lineRepository;
    }

    public function execute(?string $dateTo = null): array
    {
        $accounts = $this->accountRepository->findAll();
        $balances = [];
        foreach ($accounts as $account) {
            $lines = $this->lineRepository->findByAccountId($account->getId(), null, $dateTo);
            $debit = 0;
            $credit = 0;
            foreach ($lines as $line) {
                $debit += $line->getDebit();
                $credit += $line->getCredit();
            }
            $balances[] = [
                'id' => $account->getId(),
                'code' => $account->getCode(),
                'name' => $account->getName(),
                'type' => $account->getType(),
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $debit - $credit
            ];
        }
        return $balances;
    }
}
