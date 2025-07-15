<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\RegisterThirdParty;

class RegisterThirdPartyController
{
    private RegisterThirdParty $registerThirdParty;

    public function __construct(RegisterThirdParty $registerThirdParty)
    {
        $this->registerThirdParty = $registerThirdParty;
    }

    public function register(array $data): array
    {
        if (empty($data['name'])) {
            return [
                'status' => 400,
                'body' => ['error' => 'El campo name es requerido']
            ];
        }
        $ok = $this->registerThirdParty->execute(
            $data['name'],
            $data['document'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null
        );
        if ($ok) {
            return [
                'status' => 201,
                'body' => ['message' => 'Tercero registrado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo registrar el tercero']
        ];
    }
}
