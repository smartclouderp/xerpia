<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\DeleteUser;

class DeleteUserController {
    private DeleteUser $deleteUser;

    public function __construct(DeleteUser $deleteUser) {
        $this->deleteUser = $deleteUser;
    }

    public function delete(int $id): array {
        $ok = $this->deleteUser->execute($id);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Usuario eliminado']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Usuario no encontrado']
        ];
    }
}
