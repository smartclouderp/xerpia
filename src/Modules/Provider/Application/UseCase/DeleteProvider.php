<?php
namespace Xerpia\Modules\Provider\Application\UseCase;

use Xerpia\Modules\Provider\Domain\Repository\ProviderRepositoryInterface;

class DeleteProvider
{
    private ProviderRepositoryInterface $repository;

    public function __construct(ProviderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
