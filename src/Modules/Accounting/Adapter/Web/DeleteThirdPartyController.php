<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\DeleteThirdParty;

class DeleteThirdPartyController
{
    private DeleteThirdParty $deleteThirdParty;

    public function __construct(DeleteThirdParty $deleteThirdParty)
    {
        $this->deleteThirdParty = $deleteThirdParty;
    }

    public function delete(int $id): array
    {
        $ok = $this->deleteThirdParty->execute($id);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Tercero eliminado']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Tercero no encontrado']
        ];
    }
}
