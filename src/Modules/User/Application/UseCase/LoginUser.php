<?php
namespace Xerpia\Modules\User\Application\UseCase;

use Xerpia\Modules\User\Domain\Repository\UserRepositoryInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginUser
{
    private UserRepositoryInterface $userRepository;
    private string $jwtSecret;

    public function __construct(UserRepositoryInterface $userRepository, string $jwtSecret)
    {
        $this->userRepository = $userRepository;
        $this->jwtSecret = $jwtSecret;
    }

    public function execute(string $username, string $password): ?string
    {
        $user = $this->userRepository->findByUsername($username);
        error_log('LoginUser::execute username: ' . $username);
        if ($user) {
            error_log('LoginUser::execute hash: ' . $user->getPasswordHash());
            error_log('LoginUser::execute password_verify: ' . (password_verify($password, $user->getPasswordHash()) ? 'true' : 'false'));
        } else {
            error_log('LoginUser::execute user not found');
        }
        if (!$user || !password_verify($password, $user->getPasswordHash())) {
            return null;
        }
        $payload = [
            'sub' => $user->getId(),
            'username' => $user->getUsername(),
            'iat' => time(),
            'exp' => time() + 3600
        ];
        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }
}
