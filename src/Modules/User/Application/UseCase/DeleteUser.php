<?php
namespace Xerpia\Modules\User\Application\UseCase;

use Xerpia\Modules\User\Domain\Repository\UserWriteRepositoryInterface;

class DeleteUser {
    private UserWriteRepositoryInterface $userWriteRepository;

    public function __construct(UserWriteRepositoryInterface $userWriteRepository) {
        $this->userWriteRepository = $userWriteRepository;
    }

    public function execute(int $id): bool {
        return $this->userWriteRepository->delete($id);
    }
}
