<?php
namespace Xerpia\Modules\User\Application\UseCase;

use Xerpia\Modules\User\Domain\Repository\UserWriteRepositoryInterface;

class UpdateUser {
    private UserWriteRepositoryInterface $userWriteRepository;

    public function __construct(UserWriteRepositoryInterface $userWriteRepository) {
        $this->userWriteRepository = $userWriteRepository;
    }

    public function execute(int $id, array $data): bool {
        return $this->userWriteRepository->update($id, $data);
    }
}
