<?php
namespace Xerpia\Modules\User\Domain\Repository;

use Xerpia\Modules\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;
}
