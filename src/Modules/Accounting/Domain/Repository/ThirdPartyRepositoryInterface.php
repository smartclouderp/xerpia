<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\ThirdParty;

interface ThirdPartyRepositoryInterface
{
    public function create(ThirdParty $thirdParty): bool;
    public function update(ThirdParty $thirdParty): bool;
    public function delete(int $id): bool;
    public function findById(int $id): ?ThirdParty;
    public function findAll(): array;
}
