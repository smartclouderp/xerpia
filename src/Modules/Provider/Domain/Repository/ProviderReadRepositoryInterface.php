<?php
namespace Xerpia\Modules\Provider\Domain\Repository;

use Xerpia\Modules\Provider\Domain\Entity\Provider;

interface ProviderReadRepositoryInterface
{
    public function findById(int $id): ?Provider;
    public function findAll(): array;
}
