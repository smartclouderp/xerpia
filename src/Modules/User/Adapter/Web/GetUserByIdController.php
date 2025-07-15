<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\GetUserById;

class GetUserByIdController {
    private GetUserById $getUserById;

    public function __construct(GetUserById $getUserById) {
        $this->getUserById = $getUserById;
    }

    public function get(int $id): array {
        $user = $this->getUserById->execute($id);
        if ($user) {
            return [
                'status' => 200,
                'body' => $user
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Usuario no encontrado']
        ];
    }
}
