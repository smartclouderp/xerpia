<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbAccountRepository;
use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbJournalEntryLineRepository;
use Xerpia\Modules\Accounting\Application\UseCase\GetBalanceSheet;
use Xerpia\Modules\Accounting\Application\UseCase\GetGeneralLedger;
use Xerpia\Modules\Accounting\Application\UseCase\GetTransactions;
use Xerpia\Modules\Accounting\Application\UseCase\GetIncomeStatement;

class ReportsControllerFactory
{
    public static function create($pdo)
    {
        $accountRepo = new MariaDbAccountRepository($pdo);
        $lineRepo = new MariaDbJournalEntryLineRepository($pdo);
        return [
            'getBalanceSheetController' => new GetBalanceSheetController(new GetBalanceSheet($accountRepo, $lineRepo)),
            'getGeneralLedgerController' => new GetGeneralLedgerController(new GetGeneralLedger($accountRepo, $lineRepo)),
            'getTransactionsController' => new GetTransactionsController(new GetTransactions($lineRepo)),
            'getIncomeStatementController' => new GetIncomeStatementController(new GetIncomeStatement($accountRepo, $lineRepo)),
        ];
    }

    public static function createIncomeStatementController(
        AccountRepositoryInterface $accountRepository,
        JournalEntryLineRepositoryInterface $lineRepository
    ): GetIncomeStatementController {
        $useCase = new GetIncomeStatement($accountRepository, $lineRepository);
        return new GetIncomeStatementController($useCase);
    }
}
