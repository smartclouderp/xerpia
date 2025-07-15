<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\UpdateAccount;

class UpdateAccountController
{
    private UpdateAccount $updateAccount;

    public function __construct(UpdateAccount $updateAccount)
    {
        $this->updateAccount = $updateAccount;
    }

    public function update(int $id, array $data): array
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
        $ok = $this->updateAccount->execute($id, $data['code'], $data['name'], $data['parent_id'] ?? null, $data['type']);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Cuenta actualizada']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Cuenta no encontrada']
        ];
    }
}
