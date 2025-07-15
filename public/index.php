<?php
use Xerpia\Modules\Product\Adapter\Web\ProductListController;
use Xerpia\Modules\Product\Adapter\Web\UpdateProductController;
use Xerpia\Modules\Product\Adapter\Web\DeleteProductController;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductListRepository;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepositoryExtended;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderListRepository;
use Xerpia\Modules\Provider\Adapter\Web\ProviderListController;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderRepositoryExtended;
use Xerpia\Modules\Provider\Application\UseCase\UpdateProvider;
use Xerpia\Modules\Provider\Adapter\Web\UpdateProviderController;
use Xerpia\Modules\Provider\Application\UseCase\DeleteProvider;
use Xerpia\Modules\Provider\Adapter\Web\DeleteProviderController;
use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderReadRepository;
use Xerpia\Modules\Provider\Adapter\Web\ProviderQueryController;
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use Xerpia\Core\Database\Connection;

$config = require __DIR__ . '/../config/database.php';
$db = new Connection($config['host'], $config['db'], $config['user'], $config['pass']);


// Instancias de módulos
use Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserRepository;
use Xerpia\Modules\User\Application\UseCase\LoginUser;
use Xerpia\Modules\User\Adapter\Web\LoginController;

use Xerpia\Modules\Provider\Infrastructure\Persistence\MariaDbProviderRepository;
use Xerpia\Modules\Provider\Application\UseCase\RegisterProvider;
use Xerpia\Modules\Provider\Adapter\Web\RegisterProviderController;

$jwtSecret = 'TU_SECRETO_JWT'; // Cambia por tu secreto real
$userRepository = new MariaDbUserRepository($db->getPdo());
$loginUser = new LoginUser($userRepository, $jwtSecret);
$loginController = new LoginController($loginUser);

// Instancias para el módulo de proveedores
$providerRepository = new MariaDbProviderRepository($db->getPdo());
$registerProvider = new RegisterProvider($providerRepository);
$registerProviderController = new RegisterProviderController($registerProvider);

// Instancias para el módulo de productos
$productRepository = new Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepository($db->getPdo());
$registerProduct = new Xerpia\Modules\Product\Application\UseCase\RegisterProduct($productRepository);
$productController = new Xerpia\Modules\Product\Adapter\Web\ProductController($registerProduct);

// Instancias para listar, actualizar y eliminar productos
$productListRepository = new MariaDbProductListRepository($db->getPdo());
$productListController = new ProductListController($productListRepository);
$productRepositoryExtended = new MariaDbProductRepositoryExtended($db->getPdo());
$updateProductController = new UpdateProductController($productRepositoryExtended);
$deleteProductController = new DeleteProductController($productRepositoryExtended);

// Instancias para consulta de proveedores
$providerReadRepository = new MariaDbProviderReadRepository($db->getPdo());
$providerQueryController = new ProviderQueryController($providerReadRepository);

// Instancias para lista paginada y filtrada de proveedores
$providerListRepository = new MariaDbProviderListRepository($db->getPdo());
$providerListController = new ProviderListController($providerListRepository);

// Instancias para actualizar y eliminar proveedores
$providerRepositoryExtended = new MariaDbProviderRepositoryExtended($db->getPdo());
$updateProvider = new UpdateProvider($providerRepositoryExtended);
$updateProviderController = new UpdateProviderController($updateProvider);
$deleteProvider = new DeleteProvider($providerRepositoryExtended);
$deleteProviderController = new DeleteProviderController($deleteProvider);

// Instancias para el registro de usuarios y roles
$userWriteRepository = new Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserWriteRepository($db->getPdo());
$registerUser = new Xerpia\Modules\User\Application\UseCase\RegisterUser($userWriteRepository);
$registerUserController = new Xerpia\Modules\User\Adapter\Web\RegisterUserController($registerUser);

// Enrutador extensible
$routes = [
    // Listar productos con paginación y filtros
    'GET /products' => function($request) use ($productListController) {
        return $productListController->list($request);
    },
    'POST /login' => function($request) use ($loginController) {
        return $loginController->login($request);
    },
    'POST /products' => function($request) use ($productController) {
        return $productController->register($request);
    },
    // Actualizar producto
    'PUT /products' => function($request) use ($updateProductController) {
        return $updateProductController->update($request);
    },
    // Eliminar producto
    'DELETE /products' => function($request) use ($deleteProductController) {
        return $deleteProductController->delete($request);
    },
    'POST /users' => function($request) use ($registerUserController) {
        return $registerUserController->register($request);
    },
    'POST /providers' => function($request) use ($registerProviderController) {
        return $registerProviderController->register($request);
    },
    'GET /providers' => function($request) use ($providerQueryController) {
        return $providerQueryController->get($request);
    },
    'GET /providers/list' => function($request) use ($providerListController) {
        return $providerListController->get($request);
    },
    'PUT /providers' => function($request) use ($updateProviderController) {
        $id = isset($request['id']) ? (int)$request['id'] : 0;
        if ($id <= 0) {
            return [
                'status' => 400,
                'body' => ['error' => 'Id de proveedor requerido y válido']
            ];
        }
        return $updateProviderController->update($id, $request);
    },
    'DELETE /providers' => function($request) use ($deleteProviderController) {
        $id = isset($request['id']) ? (int)$request['id'] : 0;
        if ($id <= 0) {
            return [
                'status' => 400,
                'body' => ['error' => 'Id de proveedor requerido y válido']
            ];
        }
        return $deleteProviderController->delete($id);
    },
    // 'GET /transactions' => function($request) use ($transactionController) { ... },
];


$method = $_SERVER['REQUEST_METHOD'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
// Elimina la parte del script para obtener solo el endpoint
$basePath = rtrim(dirname($scriptName), '/\\');
$endpoint = $requestUri;
if ($basePath && strpos($endpoint, $basePath) === 0) {
    $endpoint = substr($endpoint, strlen($basePath));
}
$endpoint = str_replace('/index.php', '', $endpoint);
$endpoint = rtrim($endpoint, '/');
if ($endpoint === '') $endpoint = '/';
$key = $method . ' ' . $endpoint;

$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true) ?? [];

if (isset($routes[$key])) {
    $response = $routes[$key]($request);
    http_response_code($response['status']);
    header('Content-Type: application/json');
    echo json_encode($response['body']);
    // Solo se imprime el JSON, sin variables extra
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Endpoint not found']);
}
