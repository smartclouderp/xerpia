<?php
namespace Xerpia\Modules\User\Application\UseCase;

use Xerpia\Modules\User\Domain\Repository\UserRepositoryInterface;

class GetAllUsers {
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function execute(): array {
        return $this->userRepository->findAll();
    }
}
