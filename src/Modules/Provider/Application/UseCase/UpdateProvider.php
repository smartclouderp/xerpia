<?php
namespace Xerpia\Modules\Provider\Application\UseCase;

use Xerpia\Modules\Provider\Domain\Entity\Provider;
use Xerpia\Modules\Provider\Domain\Repository\ProviderRepositoryInterface;

class UpdateProvider
{
    private ProviderRepositoryInterface $repository;

    public function __construct(ProviderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, array $data): bool
    {
        $provider = new Provider(
            $id,
            $data['businessName'],
            $data['taxId'],
            $data['address'],
            $data['contactName'],
            $data['contactEmail'],
            $data['contactPhone']
        );
        return $this->repository->update($provider);
    }
}
