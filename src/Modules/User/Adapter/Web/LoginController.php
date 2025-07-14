<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\LoginUser;
use Xerpia\Modules\User\Adapter\Web\Dto\LoginUserDto;
use Exception;

class LoginController
{
    private LoginUser $loginUser;

    public function __construct(LoginUser $loginUser)
    {
        $this->loginUser = $loginUser;
    }

    public function login(array $request): array
    {
        $dto = new LoginUserDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $token = $this->loginUser->execute($dto->username, $dto->password);
        if (!$token) {
            return [
                'status' => 401,
                'body' => ['error' => 'Credenciales inválidas']
            ];
        }
        return [
            'status' => 200,
            'body' => ['token' => $token]
        ];
    }
}
