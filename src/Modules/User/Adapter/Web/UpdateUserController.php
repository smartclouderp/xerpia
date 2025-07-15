<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\UpdateUser;

class UpdateUserController {
    private UpdateUser $updateUser;

    public function __construct(UpdateUser $updateUser) {
        $this->updateUser = $updateUser;
    }

    public function update(int $id, array $data): array {
        $ok = $this->updateUser->execute($id, $data);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Usuario actualizado']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Usuario no encontrado']
        ];
    }
}
