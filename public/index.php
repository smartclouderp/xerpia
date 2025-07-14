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
    // 'GET /transactions' => function($request) use ($transactionController) { ... },
];

$method = $_SERVER['REQUEST_METHOD'];
$path = strtok($_SERVER['REQUEST_URI'], '?');
$key = $method . ' ' . $path;

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
