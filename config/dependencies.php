<?php
// Instancias de dependencias y controladores
use Xerpia\Core\Database\Connection;
use Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserRepository;
use Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserWriteRepository;
use Xerpia\Modules\User\Application\UseCase\LoginUser;
use Xerpia\Modules\User\Application\UseCase\RegisterUser;
use Xerpia\Modules\User\Application\UseCase\UpdateUser;
use Xerpia\Modules\User\Application\UseCase\DeleteUser;
use Xerpia\Modules\User\Application\UseCase\GetAllUsers;
use Xerpia\Modules\User\Application\UseCase\GetUserById;
use Xerpia\Modules\User\Adapter\Web\LoginController;
use Xerpia\Modules\User\Adapter\Web\RegisterUserController;
use Xerpia\Modules\User\Adapter\Web\UpdateUserController;
use Xerpia\Modules\User\Adapter\Web\DeleteUserController;
use Xerpia\Modules\User\Adapter\Web\GetAllUsersController;
use Xerpia\Modules\User\Adapter\Web\GetUserByIdController;
// ...otros use y controladores...

return function($db, $jwtSecret) {
    $userRepository = new MariaDbUserRepository($db->getPdo());
    $userWriteRepository = new MariaDbUserWriteRepository($db->getPdo());
    $loginUser = new LoginUser($userRepository, $jwtSecret);
    $registerUser = new RegisterUser($userWriteRepository);
    $updateUser = new UpdateUser($userWriteRepository);
    $deleteUser = new DeleteUser($userWriteRepository);
    $getAllUsers = new GetAllUsers($userRepository);
    $getUserById = new GetUserById($userRepository);

    return [
        'loginController' => new LoginController($loginUser),
        'registerUserController' => new RegisterUserController($registerUser),
        'updateUserController' => new UpdateUserController($updateUser),
        'deleteUserController' => new DeleteUserController($deleteUser),
        'getAllUsersController' => new GetAllUsersController($getAllUsers),
        'getUserByIdController' => new GetUserByIdController($getUserById),
        // ...otros controladores...
    ];
};
