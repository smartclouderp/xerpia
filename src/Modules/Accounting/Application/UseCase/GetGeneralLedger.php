<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class GetGeneralLedger
{
    private AccountRepositoryInterface $accountRepository;
    private JournalEntryLineRepositoryInterface $lineRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, JournalEntryLineRepositoryInterface $lineRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->lineRepository = $lineRepository;
    }

    public function execute(?int $accountId = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $accounts = $accountId ? [$this->accountRepository->findById($accountId)] : $this->accountRepository->findAll();
        $ledger = [];
        foreach ($accounts as $account) {
            if (!$account) continue;
            $lines = $this->lineRepository->findByAccountId($account->getId(), $dateFrom, $dateTo);
            $movements = [];
            $balance = 0;
            foreach ($lines as $line) {
                $balance += $line->getDebit() - $line->getCredit();
                $movements[] = [
                    'date' => $line->getDate(),
                    'debit' => $line->getDebit(),
                    'credit' => $line->getCredit(),
                    'balance' => $balance,
                    'description' => $line->getDescription(),
                    'journal_entry_id' => $line->getJournalEntryId()
                ];
            }
            $ledger[] = [
                'account_id' => $account->getId(),
                'account_code' => $account->getCode(),
                'account_name' => $account->getName(),
                'type' => $account->getType(),
                'movements' => $movements
            ];
        }
        return $ledger;
    }
}
