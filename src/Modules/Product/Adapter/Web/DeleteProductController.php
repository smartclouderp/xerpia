<?php
namespace Xerpia\Modules\Product\Adapter\Web;

use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepositoryExtended;

class DeleteProductController
{
    private MariaDbProductRepositoryExtended $repository;

    public function __construct(MariaDbProductRepositoryExtended $repository)
    {
        $this->repository = $repository;
    }

    public function delete(array $request): array
    {
        $id = $request['id'] ?? 0;
        if (!$id) {
            return [
                'status' => 400,
                'body' => ['error' => 'Id de producto requerido']
            ];
        }
        $result = $this->repository->delete($id);
        if ($result) {
            return [
                'status' => 200,
                'body' => ['message' => 'Producto eliminado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo eliminar el producto']
        ];
    }
}
