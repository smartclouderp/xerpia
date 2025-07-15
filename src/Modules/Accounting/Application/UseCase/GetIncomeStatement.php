<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class GetIncomeStatement
{
    private AccountRepositoryInterface $accountRepository;
    private JournalEntryLineRepositoryInterface $lineRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, JournalEntryLineRepositoryInterface $lineRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->lineRepository = $lineRepository;
    }

    public function execute(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $accounts = $this->accountRepository->findAll();
        $income = 0;
        $expense = 0;
        $details = [];
        foreach ($accounts as $account) {
            if (!in_array($account->getType(), ['income', 'expense'])) continue;
            $lines = $this->lineRepository->findByAccountId($account->getId(), $dateFrom, $dateTo);
            $debit = 0;
            $credit = 0;
            foreach ($lines as $line) {
                $debit += $line->getDebit();
                $credit += $line->getCredit();
            }
            $balance = $debit - $credit;
            $details[] = [
                'id' => $account->getId(),
                'code' => $account->getCode(),
                'name' => $account->getName(),
                'type' => $account->getType(),
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $balance
            ];
            if ($account->getType() === 'income') {
                $income += $balance;
            } else {
                $expense += $balance;
            }
        }
        $net = $income - abs($expense);
        return [
            'income' => $income,
            'expense' => abs($expense),
            'net_income' => $net,
            'details' => $details
        ];
    }
}
