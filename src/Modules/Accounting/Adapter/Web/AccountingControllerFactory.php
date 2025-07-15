<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbAccountRepository;
use Xerpia\Modules\Accounting\Application\UseCase\RegisterAccount;
use Xerpia\Modules\Accounting\Application\UseCase\GetAllAccounts;
use Xerpia\Modules\Accounting\Application\UseCase\UpdateAccount;
use Xerpia\Modules\Accounting\Application\UseCase\DeleteAccount;
use Xerpia\Modules\Accounting\Application\UseCase\GetAccountById;

class AccountingControllerFactory
{
    public static function create($pdo)
    {
        $accountRepository = new MariaDbAccountRepository($pdo);
        return [
            'registerAccountController' => new RegisterAccountController(new RegisterAccount($accountRepository)),
            'getAllAccountsController' => new GetAllAccountsController(new GetAllAccounts($accountRepository)),
            'updateAccountController' => new UpdateAccountController(new UpdateAccount($accountRepository)),
            'deleteAccountController' => new DeleteAccountController(new DeleteAccount($accountRepository)),
            'getAccountByIdController' => new GetAccountByIdController(new GetAccountById($accountRepository)),
        ];
    }
}
