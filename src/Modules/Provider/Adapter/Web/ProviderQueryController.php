<?php
namespace Xerpia\Modules\Provider\Adapter\Web;

use Xerpia\Modules\Provider\Adapter\Web\Dto\ProviderQueryDto;
use Xerpia\Modules\Provider\Domain\Repository\ProviderReadRepositoryInterface;

class ProviderQueryController
{
    private ProviderReadRepositoryInterface $repository;

    public function __construct(ProviderReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get(array $request): array
    {
        $dto = new ProviderQueryDto($request);
        $errors = $dto->isValid();
        if ($errors) {
            return [
                'status' => 400,
                'body' => ['errors' => $errors]
            ];
        }
        if ($dto->id !== null) {
            $provider = $this->repository->findById($dto->id);
            if (!$provider) {
                return [
                    'status' => 404,
                    'body' => ['error' => 'Proveedor no encontrado']
                ];
            }
            return [
                'status' => 200,
                'body' => [
                    'provider' => [
                        'id' => $provider->getId(),
                        'businessName' => $provider->getBusinessName(),
                        'taxId' => $provider->getTaxId(),
                        'address' => $provider->getAddress(),
                        'contactName' => $provider->getContactName(),
                        'contactEmail' => $provider->getContactEmail(),
                        'contactPhone' => $provider->getContactPhone()
                    ]
                ]
            ];
        } else {
            $providers = $this->repository->findAll();
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
}
