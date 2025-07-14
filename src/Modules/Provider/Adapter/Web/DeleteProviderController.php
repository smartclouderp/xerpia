<?php
namespace Xerpia\Modules\Provider\Adapter\Web;

use Xerpia\Modules\Provider\Application\UseCase\DeleteProvider;

class DeleteProviderController
{
    private DeleteProvider $deleteProvider;

    public function __construct(DeleteProvider $deleteProvider)
    {
        $this->deleteProvider = $deleteProvider;
    }

    public function delete(int $id): array
    {
        $result = $this->deleteProvider->execute($id);
        if ($result) {
            return [
                'status' => 200,
                'body' => ['message' => 'Proveedor eliminado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo eliminar el proveedor']
        ];
    }
}
