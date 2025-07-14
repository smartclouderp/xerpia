// Instancias para el registro de usuarios y roles
$userWriteRepository = new Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserWriteRepository($db->getPdo());
$registerUser = new Xerpia\Modules\User\Application\UseCase\RegisterUser($userWriteRepository);
$registerUserController = new Xerpia\Modules\User\Adapter\Web\RegisterUserController($registerUser);
$productRepository = new Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepository($db->getPdo());
$registerProduct = new Xerpia\Modules\Product\Application\UseCase\RegisterProduct($productRepository);
$productController = new Xerpia\Modules\Product\Adapter\Web\ProductController($registerProduct);
<?php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use Xerpia\Core\Database\Connection;

$config = require __DIR__ . '/../config/database.php';
$db = new Connection($config['host'], $config['db'], $config['user'], $config['pass']);


// Instancias de módulos
use Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserRepository;
use Xerpia\Modules\User\Application\UseCase\LoginUser;
use Xerpia\Modules\User\Adapter\Web\LoginController;

$jwtSecret = 'TU_SECRETO_JWT'; // Cambia por tu secreto real
$userRepository = new MariaDbUserRepository($db->getPdo());
$loginUser = new LoginUser($userRepository, $jwtSecret);
$loginController = new LoginController($loginUser);

// Instancias para el módulo de productos
$productRepository = new Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepository($db->getPdo());
$registerProduct = new Xerpia\Modules\Product\Application\UseCase\RegisterProduct($productRepository);
$productController = new Xerpia\Modules\Product\Adapter\Web\ProductController($registerProduct);

// Instancias para el registro de usuarios y roles
$userWriteRepository = new Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserWriteRepository($db->getPdo());
$registerUser = new Xerpia\Modules\User\Application\UseCase\RegisterUser($userWriteRepository);
$registerUserController = new Xerpia\Modules\User\Adapter\Web\RegisterUserController($registerUser);

// Enrutador extensible
$routes = [
    'POST /login' => function($request) use ($loginController) {
        return $loginController->login($request);
    },
    'POST /products' => function($request) use ($productController) {
        // Validación básica
        if (!isset($request['name'], $request['price'], $request['stock'])) {
            return [
                'status' => 400,
                'body' => ['error' => 'Faltan datos del producto']
            ];
        }
        $productController->register($request);
        return [
            'status' => 201,
            'body' => ['message' => 'Producto registrado']
        ];
    },
    'POST /users' => function($request) use ($registerUserController) {
        return $registerUserController->register($request);
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
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Endpoint not found']);
}
