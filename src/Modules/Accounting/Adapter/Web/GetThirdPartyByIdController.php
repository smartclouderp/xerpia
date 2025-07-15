<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\GetThirdPartyById;

class GetThirdPartyByIdController
{
    private GetThirdPartyById $getThirdPartyById;

    public function __construct(GetThirdPartyById $getThirdPartyById)
    {
        $this->getThirdPartyById = $getThirdPartyById;
    }

    public function get(int $id): array
    {
        $thirdParty = $this->getThirdPartyById->execute($id);
        if ($thirdParty) {
            return [
                'status' => 200,
                'body' => [
                    'id' => $thirdParty->getId(),
                    'name' => $thirdParty->getName(),
                    'document' => $thirdParty->getDocument(),
                    'email' => $thirdParty->getEmail(),
                    'phone' => $thirdParty->getPhone()
                ]
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Tercero no encontrado']
        ];
    }
}
