<?php
namespace Xerpia\Modules\Provider\Adapter\Web;

use Xerpia\Modules\Provider\Application\UseCase\UpdateProvider;
use Xerpia\Modules\Provider\Adapter\Web\Dto\RegisterProviderDto;

class UpdateProviderController
{
    private UpdateProvider $updateProvider;

    public function __construct(UpdateProvider $updateProvider)
    {
        $this->updateProvider = $updateProvider;
    }

    public function update(int $id, array $request): array
    {
        $dto = new RegisterProviderDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $result = $this->updateProvider->execute($id, [
            'businessName' => $dto->businessName,
            'taxId' => $dto->taxId,
            'address' => $dto->address,
            'contactName' => $dto->contactName,
            'contactEmail' => $dto->contactEmail,
            'contactPhone' => $dto->contactPhone
        ]);
        if ($result) {
            return [
                'status' => 200,
                'body' => ['message' => 'Proveedor actualizado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo actualizar el proveedor']
        ];
    }
}
