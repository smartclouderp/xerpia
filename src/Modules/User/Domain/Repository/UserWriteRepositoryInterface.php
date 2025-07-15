<?php
namespace Xerpia\Modules\User\Domain\Repository;

use Xerpia\Modules\User\Domain\Entity\User;

interface UserWriteRepositoryInterface
{
    public function create(User $user, array $roles): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
