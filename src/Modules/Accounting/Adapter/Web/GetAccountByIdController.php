<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetAccountById;

class GetAccountByIdController
{
    private GetAccountById $getAccountById;

    public function __construct(GetAccountById $getAccountById)
    {
        $this->getAccountById = $getAccountById;
    }

    public function get(int $id): array
    {
        $account = $this->getAccountById->execute($id);
        if ($account) {
            return [
                'status' => 200,
                'body' => [
                    'id' => $account->getId(),
                    'code' => $account->getCode(),
                    'name' => $account->getName(),
                    'parent_id' => $account->getParentId(),
                    'type' => $account->getType()
                ]
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Cuenta no encontrada']
        ];
    }
}
