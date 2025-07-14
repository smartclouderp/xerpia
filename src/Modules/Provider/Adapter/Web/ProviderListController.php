<?php
namespace Xerpia\Modules\Provider\Adapter\Web;

use Xerpia\Modules\Provider\Adapter\Web\Dto\ProviderListQueryDto;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderListRepository;

class ProviderListController
{
    private MariaDbProviderListRepository $repository;

    public function __construct(MariaDbProviderListRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(array $request): array
    {
        $dto = new ProviderListQueryDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        $providers = $this->repository->findAllPaginated($dto->page, $dto->limit, $dto->search);
        $result = [];
        foreach ($providers as $provider) {
            $result[] = [
                'id' => $provider->getId(),
                'businessName' => $provider->getBusinessName(),
                'taxId' => $provider->getTaxId(),
                'address' => $provider->getAddress(),
                'contactName' => $provider->getContactName(),
                'contactEmail' => $provider->getContactEmail(),
                'contactPhone' => $provider->getContactPhone()
            ];
        }
        return [
            'status' => 200,
            'body' => ['providers' => $result]
        ];
    }
}
