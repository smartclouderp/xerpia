<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\DeleteAccount;

class DeleteAccountController
{
    private DeleteAccount $deleteAccount;

    public function __construct(DeleteAccount $deleteAccount)
    {
        $this->deleteAccount = $deleteAccount;
    }

    public function delete(int $id): array
    {
        $ok = $this->deleteAccount->execute($id);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Cuenta eliminada']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Cuenta no encontrada']
        ];
    }
}
