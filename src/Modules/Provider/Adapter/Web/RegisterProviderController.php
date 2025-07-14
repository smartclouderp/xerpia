<?php
namespace Xerpia\Modules\Provider\Adapter\Web;

use Xerpia\Modules\Provider\Application\UseCase\RegisterProvider;
use Xerpia\Modules\Provider\Adapter\Web\Dto\RegisterProviderDto;

class RegisterProviderController
{
    private RegisterProvider $registerProvider;

    public function __construct(RegisterProvider $registerProvider)
    {
        $this->registerProvider = $registerProvider;
    }

    public function register(array $request): array
    {
        $dto = new RegisterProviderDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $result = $this->registerProvider->execute([
            'businessName' => $dto->businessName,
            'taxId' => $dto->taxId,
            'address' => $dto->address,
            'contactName' => $dto->contactName,
            'contactEmail' => $dto->contactEmail,
            'contactPhone' => $dto->contactPhone
        ]);
        if ($result) {
            return [
                'status' => 201,
                'body' => ['message' => 'Proveedor registrado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo registrar el proveedor']
        ];
    }
}
