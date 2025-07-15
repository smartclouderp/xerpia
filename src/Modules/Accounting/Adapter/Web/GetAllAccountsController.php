<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetAllAccounts;

class GetAllAccountsController
{
    private GetAllAccounts $getAllAccounts;

    public function __construct(GetAllAccounts $getAllAccounts)
    {
        $this->getAllAccounts = $getAllAccounts;
    }

    public function get(): array
    {
        $accounts = $this->getAllAccounts->execute();
        $data = array_map(function($acc) {
            return [
                'id' => $acc->getId(),
                'code' => $acc->getCode(),
                'name' => $acc->getName(),
                'parent_id' => $acc->getParentId(),
                'type' => $acc->getType()
            ];
        }, $accounts);
        return [
            'status' => 200,
            'body' => ['data' => $data]
        ];
    }
}
