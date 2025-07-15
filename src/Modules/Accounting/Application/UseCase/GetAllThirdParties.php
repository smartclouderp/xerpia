<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\ThirdPartyRepositoryInterface;

class GetAllThirdParties
{
    private ThirdPartyRepositoryInterface $thirdPartyRepository;

    public function __construct(ThirdPartyRepositoryInterface $thirdPartyRepository)
    {
        $this->thirdPartyRepository = $thirdPartyRepository;
    }

    public function execute(): array
    {
        return $this->thirdPartyRepository->findAll();
    }
}
