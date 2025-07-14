<?php
namespace Xerpia\Modules\User\Application\UseCase;

use Xerpia\Modules\User\Domain\Entity\User;
use Xerpia\Modules\User\Domain\Repository\UserWriteRepositoryInterface;

class RegisterUser
{
    private UserWriteRepositoryInterface $userWriteRepository;

    public function __construct(UserWriteRepositoryInterface $userWriteRepository)
    {
        $this->userWriteRepository = $userWriteRepository;
    }

    public function execute(string $username, string $password, array $roles): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $user = new User(0, $username, $passwordHash);
        return $this->userWriteRepository->create($user, $roles);
    }
}
