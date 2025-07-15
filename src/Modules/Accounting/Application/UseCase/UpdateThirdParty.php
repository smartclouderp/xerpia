<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Entity\ThirdParty;
use Xerpia\Modules\Accounting\Domain\Repository\ThirdPartyRepositoryInterface;

class UpdateThirdParty
{
    private ThirdPartyRepositoryInterface $thirdPartyRepository;

    public function __construct(ThirdPartyRepositoryInterface $thirdPartyRepository)
    {
        $this->thirdPartyRepository = $thirdPartyRepository;
    }

    public function execute(int $id, string $name, ?string $document = null, ?string $email = null, ?string $phone = null): bool
    {
        $thirdParty = new ThirdParty($id, $name, $document, $email, $phone);
        return $this->thirdPartyRepository->update($thirdParty);
    }
}
