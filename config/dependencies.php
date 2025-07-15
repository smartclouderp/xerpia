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
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepository;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductListRepository;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepositoryExtended;
use Xerpia\Modules\Product\Application\UseCase\RegisterProduct;
use Xerpia\Modules\Product\Adapter\Web\ProductController;
use Xerpia\Modules\Product\Adapter\Web\ProductListController;
use Xerpia\Modules\Product\Adapter\Web\UpdateProductController;
use Xerpia\Modules\Product\Adapter\Web\DeleteProductController;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderRepository;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderRepositoryExtended;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderReadRepository;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderListRepository;
use Xerpia\Modules\Provider\Application\UseCase\RegisterProvider;
use Xerpia\Modules\Provider\Application\UseCase\UpdateProvider;
use Xerpia\Modules\Provider\Application\UseCase\DeleteProvider;
use Xerpia\Modules\Provider\Adapter\Web\RegisterProviderController;
use Xerpia\Modules\Provider\Adapter\Web\UpdateProviderController;
use Xerpia\Modules\Provider\Adapter\Web\DeleteProviderController;
use Xerpia\Modules\Provider\Adapter\Web\ProviderQueryController;
use Xerpia\Modules\Provider\Adapter\Web\ProviderListController;

return function($db, $jwtSecret) {
    $userRepository = new MariaDbUserRepository($db->getPdo());
    $userWriteRepository = new MariaDbUserWriteRepository($db->getPdo());
    $loginUser = new LoginUser($userRepository, $jwtSecret);
    $registerUser = new RegisterUser($userWriteRepository);
    $updateUser = new UpdateUser($userWriteRepository);
    $deleteUser = new DeleteUser($userWriteRepository);
    $getAllUsers = new GetAllUsers($userRepository);
    $getUserById = new GetUserById($userRepository);

    // Productos
    $productRepository = new MariaDbProductRepository($db->getPdo());
    $productListRepository = new MariaDbProductListRepository($db->getPdo());
    $productRepositoryExtended = new MariaDbProductRepositoryExtended($db->getPdo());
    $registerProduct = new RegisterProduct($productRepository);

    // Proveedores
    $providerRepository = new MariaDbProviderRepository($db->getPdo());
    $providerRepositoryExtended = new MariaDbProviderRepositoryExtended($db->getPdo());
    $providerReadRepository = new MariaDbProviderReadRepository($db->getPdo());
    $providerListRepository = new MariaDbProviderListRepository($db->getPdo());
    $registerProvider = new RegisterProvider($providerRepository);
    $updateProvider = new UpdateProvider($providerRepositoryExtended);
    $deleteProvider = new DeleteProvider($providerRepositoryExtended);

    return [
        'loginController' => new LoginController($loginUser),
        'registerUserController' => new RegisterUserController($registerUser),
        'updateUserController' => new UpdateUserController($updateUser),
        'deleteUserController' => new DeleteUserController($deleteUser),
        'getAllUsersController' => new GetAllUsersController($getAllUsers),
        'getUserByIdController' => new GetUserByIdController($getUserById),
        // Productos
        'productController' => new ProductController($registerProduct),
        'productListController' => new ProductListController($productListRepository),
        'updateProductController' => new UpdateProductController($productRepositoryExtended),
        'deleteProductController' => new DeleteProductController($productRepositoryExtended),
        // Proveedores
        'registerProviderController' => new RegisterProviderController($registerProvider),
        'updateProviderController' => new UpdateProviderController($updateProvider),
        'deleteProviderController' => new DeleteProviderController($deleteProvider),
        'providerQueryController' => new ProviderQueryController($providerReadRepository),
        'providerListController' => new ProviderListController($providerListRepository),
        // ...otros controladores...
    ];
};
