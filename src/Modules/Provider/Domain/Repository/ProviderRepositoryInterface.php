<?php
namespace Xerpia\Modules\Provider\Domain\Repository;

use Xerpia\Modules\Provider\Domain\Entity\Provider;

interface ProviderRepositoryInterface
{
    public function save(Provider $provider): bool;
}
