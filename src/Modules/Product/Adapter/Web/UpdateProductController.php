<?php
namespace Xerpia\Modules\Product\Adapter\Web;

use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepositoryExtended;
use Xerpia\Modules\Product\Adapter\Web\Dto\RegisterProductDto;

class UpdateProductController
{
    private MariaDbProductRepositoryExtended $repository;

    public function __construct(MariaDbProductRepositoryExtended $repository)
    {
        $this->repository = $repository;
    }

    public function update(array $request): array
    {
        $dto = new RegisterProductDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $id = $request['id'] ?? 0;
        if (!$id) {
            return [
                'status' => 400,
                'body' => ['error' => 'Id de producto requerido']
            ];
        }
        $result = $this->repository->update($id, [
            'name' => $dto->name,
            'price' => $dto->price,
            'stock' => $dto->stock
        ]);
        if ($result) {
            return [
                'status' => 200,
                'body' => ['message' => 'Producto actualizado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo actualizar el producto']
        ];
    }
}
