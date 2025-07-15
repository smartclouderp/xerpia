<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\RegisterAccount;

class RegisterAccountController
{
    private RegisterAccount $registerAccount;

    public function __construct(RegisterAccount $registerAccount)
    {
        $this->registerAccount = $registerAccount;
    }

    public function register(array $data): array
    {
        $required = ['code', 'name', 'type'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return [
                    'status' => 400,
                    'body' => ['error' => "El campo $field es requerido"]
                ];
            }
        }
        $ok = $this->registerAccount->execute($data['code'], $data['name'], $data['parent_id'] ?? null, $data['type']);
        if ($ok) {
            return [
                'status' => 201,
                'body' => ['message' => 'Cuenta registrada']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo registrar la cuenta']
        ];
    }
}
