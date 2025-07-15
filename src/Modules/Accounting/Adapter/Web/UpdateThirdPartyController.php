<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\UpdateThirdParty;

class UpdateThirdPartyController
{
    private UpdateThirdParty $updateThirdParty;

    public function __construct(UpdateThirdParty $updateThirdParty)
    {
        $this->updateThirdParty = $updateThirdParty;
    }

    public function update(int $id, array $data): array
    {
        if (empty($data['name'])) {
            return [
                'status' => 400,
                'body' => ['error' => 'El campo name es requerido']
            ];
        }
        $ok = $this->updateThirdParty->execute(
            $id,
            $data['name'],
            $data['document'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null
        );
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Tercero actualizado']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Tercero no encontrado']
        ];
    }
}
