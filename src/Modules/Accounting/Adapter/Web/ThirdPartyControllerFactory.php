<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbThirdPartyRepository;
use Xerpia\Modules\Accounting\Application\UseCase\RegisterThirdParty;
use Xerpia\Modules\Accounting\Application\UseCase\UpdateThirdParty;
use Xerpia\Modules\Accounting\Application\UseCase\DeleteThirdParty;
use Xerpia\Modules\Accounting\Application\UseCase\GetThirdPartyById;
use Xerpia\Modules\Accounting\Application\UseCase\GetAllThirdParties;

class ThirdPartyControllerFactory
{
    public static function create($pdo)
    {
        $repo = new MariaDbThirdPartyRepository($pdo);
        return [
            'registerThirdPartyController' => new RegisterThirdPartyController(new RegisterThirdParty($repo)),
            'updateThirdPartyController' => new UpdateThirdPartyController(new UpdateThirdParty($repo)),
            'deleteThirdPartyController' => new DeleteThirdPartyController(new DeleteThirdParty($repo)),
            'getThirdPartyByIdController' => new GetThirdPartyByIdController(new GetThirdPartyById($repo)),
            'getAllThirdPartiesController' => new GetAllThirdPartiesController(new GetAllThirdParties($repo)),
        ];
    }
}
