<?php
namespace Xerpia\Modules\Provider\Application\UseCase;

use Xerpia\Modules\Provider\Domain\Entity\Provider;
use Xerpia\Modules\Provider\Domain\Repository\ProviderRepositoryInterface;

class RegisterProvider
{
    private ProviderRepositoryInterface $repository;

    public function __construct(ProviderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): bool
    {
        $provider = new Provider(
            0,
            $data['businessName'],
            $data['taxId'],
            $data['address'],
            $data['contactName'],
            $data['contactEmail'],
            $data['contactPhone']
        );
        return $this->repository->save($provider);
    }
}
