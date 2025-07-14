<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\RegisterUser;

class RegisterUserController
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function register(array $request): array
    {
        $username = $request['username'] ?? '';
        $password = $request['password'] ?? '';
        $roles = $request['roles'] ?? [];
        if (!$username || !$password || empty($roles)) {
            return [
                'status' => 400,
                'body' => ['error' => 'Username, password y roles son requeridos']
            ];
        }
        $result = $this->registerUser->execute($username, $password, $roles);
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
