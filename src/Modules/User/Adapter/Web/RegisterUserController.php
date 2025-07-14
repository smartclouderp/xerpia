<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\RegisterUser;
use Xerpia\Modules\User\Adapter\Web\Dto\RegisterUserDto;

class RegisterUserController
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function register(array $request): array
    {
        $dto = new RegisterUserDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $result = $this->registerUser->execute($dto->username, $dto->password, $dto->roles);
        if ($result) {
            return [
                'status' => 201,
                'body' => ['message' => 'Usuario creado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo crear el usuario']
        ];
    }
}
