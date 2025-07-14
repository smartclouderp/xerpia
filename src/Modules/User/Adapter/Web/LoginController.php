<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\LoginUser;
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
        $username = $request['username'] ?? '';
        $password = $request['password'] ?? '';
        if (!$username || !$password) {
            return [
                'status' => 400,
                'body' => ['error' => 'Username and password required']
            ];
        }
        $token = $this->loginUser->execute($username, $password);
        if (!$token) {
            return [
                'status' => 401,
                'body' => ['error' => 'Invalid credentials']
            ];
        }
        return [
            'status' => 200,
            'body' => ['token' => $token]
        ];
    }
}
