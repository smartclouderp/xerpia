<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\ThirdPartyRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Entity\ThirdParty;

class GetThirdPartyById
{
    private ThirdPartyRepositoryInterface $thirdPartyRepository;

    public function __construct(ThirdPartyRepositoryInterface $thirdPartyRepository)
    {
        $this->thirdPartyRepository = $thirdPartyRepository;
    }

    public function execute(int $id): ?ThirdParty
    {
        return $this->thirdPartyRepository->findById($id);
    }
}
