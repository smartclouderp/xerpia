<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetAllThirdParties;

class GetAllThirdPartiesController
{
    private GetAllThirdParties $getAllThirdParties;

    public function __construct(GetAllThirdParties $getAllThirdParties)
    {
        $this->getAllThirdParties = $getAllThirdParties;
    }

    public function get(): array
    {
        $thirdParties = $this->getAllThirdParties->execute();
        $data = array_map(function($tp) {
            return [
                'id' => $tp->getId(),
                'name' => $tp->getName(),
                'document' => $tp->getDocument(),
                'email' => $tp->getEmail(),
                'phone' => $tp->getPhone()
            ];
        }, $thirdParties);
        return [
            'status' => 200,
            'body' => ['data' => $data]
        ];
    }
}
