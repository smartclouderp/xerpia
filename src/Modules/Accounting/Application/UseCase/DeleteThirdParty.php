<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\ThirdPartyRepositoryInterface;

class DeleteThirdParty
{
    private ThirdPartyRepositoryInterface $thirdPartyRepository;

    public function __construct(ThirdPartyRepositoryInterface $thirdPartyRepository)
    {
        $this->thirdPartyRepository = $thirdPartyRepository;
    }

    public function execute(int $id): bool
    {
        return $this->thirdPartyRepository->delete($id);
    }
}
