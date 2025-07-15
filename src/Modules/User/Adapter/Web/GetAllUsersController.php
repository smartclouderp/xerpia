<?php
namespace Xerpia\Modules\User\Adapter\Web;

use Xerpia\Modules\User\Application\UseCase\GetAllUsers;

class GetAllUsersController {
    private GetAllUsers $getAllUsers;

    public function __construct(GetAllUsers $getAllUsers) {
        $this->getAllUsers = $getAllUsers;
    }

    public function get(): array {
        $users = $this->getAllUsers->execute();
        return [
            'status' => 200,
            'body' => ['data' => $users]
        ];
    }
}
