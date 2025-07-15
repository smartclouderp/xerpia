
<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar .env si existe
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

require_once __DIR__ . '/../vendor/autoload.php';

// Configuración y conexión
use Xerpia\Core\Database\Connection;
$config = require __DIR__ . '/../config/database.php';
$db = new Connection($config['host'], $config['db'], $config['user'], $config['pass']);

// Dependencias
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// User
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

// Product
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepository;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductListRepository;
use Xerpia\Modules\Product\Infrastructure\Persistence\MariaDbProductRepositoryExtended;
use Xerpia\Modules\Product\Application\UseCase\RegisterProduct;
use Xerpia\Modules\Product\Adapter\Web\ProductController;
use Xerpia\Modules\Product\Adapter\Web\ProductListController;
use Xerpia\Modules\Product\Adapter\Web\UpdateProductController;
use Xerpia\Modules\Product\Adapter\Web\DeleteProductController;

// Provider
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

// Reports
use Xerpia\Modules\Accounting\Adapter\Web\ReportsControllerFactory;
use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbAccountRepository;
use Xerpia\Modules\Accounting\Infrastructure\Persistence\MariaDbJournalEntryLineRepository;
use Xerpia\Modules\Accounting\Application\UseCase\GetIncomeStatement;
use Xerpia\Modules\Accounting\Adapter\Web\GetIncomeStatementController;

// JWT
$jwtSecret = 'TU_SECRETO_JWT';

// Instancias Usuario
$userRepository = new MariaDbUserRepository($db->getPdo());
$userWriteRepository = new MariaDbUserWriteRepository($db->getPdo());
$loginUser = new LoginUser($userRepository, $jwtSecret);
$registerUser = new RegisterUser($userWriteRepository);
$updateUser = new UpdateUser($userWriteRepository);
$deleteUser = new DeleteUser($userWriteRepository);
$getAllUsers = new GetAllUsers($userRepository);
$getUserById = new GetUserById($userRepository);

// Controllers Usuario
$loginController = new LoginController($loginUser);
$registerUserController = new RegisterUserController($registerUser);
$updateUserController = new UpdateUserController($updateUser);
$deleteUserController = new DeleteUserController($deleteUser);
$getAllUsersController = new GetAllUsersController($getAllUsers);
$getUserByIdController = new GetUserByIdController($getUserById);

// Instancias Producto
$productRepository = new MariaDbProductRepository($db->getPdo());
$productListRepository = new MariaDbProductListRepository($db->getPdo());
$productRepositoryExtended = new MariaDbProductRepositoryExtended($db->getPdo());
$registerProduct = new RegisterProduct($productRepository);

// Controllers Producto
$productController = new ProductController($registerProduct);
$productListController = new ProductListController($productListRepository);
$updateProductController = new UpdateProductController($productRepositoryExtended);
$deleteProductController = new DeleteProductController($productRepositoryExtended);

// Instancias Proveedor
$providerRepository = new MariaDbProviderRepository($db->getPdo());
$providerRepositoryExtended = new MariaDbProviderRepositoryExtended($db->getPdo());
$providerReadRepository = new MariaDbProviderReadRepository($db->getPdo());
$providerListRepository = new MariaDbProviderListRepository($db->getPdo());
$registerProvider = new RegisterProvider($providerRepository);
$updateProvider = new UpdateProvider($providerRepositoryExtended);
$deleteProvider = new DeleteProvider($providerRepositoryExtended);

// Controllers Proveedor
$registerProviderController = new RegisterProviderController($registerProvider);
$updateProviderController = new UpdateProviderController($updateProvider);
$deleteProviderController = new DeleteProviderController($deleteProvider);
$providerQueryController = new ProviderQueryController($providerReadRepository);
$providerListController = new ProviderListController($providerListRepository);

// Controllers de reportes contables
$reportsControllers = ReportsControllerFactory::create($db->getPdo());

// Rutas
if (!isset($routesSwagger) || !is_array($routesSwagger)) {
    $routesSwagger = [];
}
$routes = array_merge($routesSwagger, [
    'POST /login' => fn($req) => $loginController->login($req),
    'POST /users' => fn($req) => $registerUserController->register($req),
    'PUT /users' => fn($req) => ($id = $req['id'] ?? 0) > 0
        ? $updateUserController->update((int)$id, $req)
        : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
    'DELETE /users' => fn($req) => ($id = $req['id'] ?? 0) > 0
        ? $deleteUserController->delete((int)$id)
        : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
    'GET /users' => fn() => $getAllUsersController->get(),
    'GET /users/id' => fn($req) => ($id = $req['id'] ?? 0) > 0
        ? $getUserByIdController->get((int)$id)
        : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
    'POST /products' => fn($req) => $productController->register($req),
    'GET /products' => fn($req) => $productListController->list($req),
    'PUT /products' => fn($req) => $updateProductController->update($req),
    'DELETE /products' => fn($req) => $deleteProductController->delete($req),
    'POST /providers' => fn($req) => $registerProviderController->register($req),
    'GET /providers' => fn($req) => $providerQueryController->get($req),
    'GET /providers/list' => fn($req) => $providerListController->get($req),
    'PUT /providers' => fn($req) => ($id = $req['id'] ?? 0) > 0
        ? $updateProviderController->update((int)$id, $req)
        : ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']],
    'DELETE /providers' => fn($req) => ($id = $req['id'] ?? 0) > 0
        ? $deleteProviderController->delete((int)$id)
        : ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']],
    'GET /reports/balance-sheet' => fn($req) => $reportsControllers['getBalanceSheetController']->get($req['date_to'] ?? null),
    'GET /reports/general-ledger' => fn($req) => $reportsControllers['getGeneralLedgerController']->get(
        isset($req['account_id']) ? (int)$req['account_id'] : null,
        $req['date_from'] ?? null,
        $req['date_to'] ?? null
    ),
    'GET /reports/transactions' => fn($req) => $reportsControllers['getTransactionsController']->get(
        $req['date_from'] ?? null,
        $req['date_to'] ?? null,
        isset($req['account_id']) ? (int)$req['account_id'] : null,
        isset($req['third_party_id']) ? (int)$req['third_party_id'] : null
    ),
    'GET /reports/income-statement' => function($req) use ($db) {
        $accountRepo = new MariaDbAccountRepository($db->getPdo());
        $lineRepo = new MariaDbJournalEntryLineRepository($db->getPdo());
        $controller = new GetIncomeStatementController(new GetIncomeStatement($accountRepo, $lineRepo));
        return $controller->__invoke([
            'dateFrom' => $req['date_from'] ?? null,
            'dateTo' => $req['date_to'] ?? null
        ]);
    },
]);

// JWT
function verify_jwt($jwtSecret): array|false {
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
        return false;
    }
    $jwt = trim(substr($headers['Authorization'], 7));
    try {
        return (array)JWT::decode($jwt, new Key($jwtSecret, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}

// Enrutamiento
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = rtrim(dirname($scriptName), '/\\');
$endpoint = str_replace('/index.php', '', $requestUri);
if ($basePath && str_starts_with($endpoint, $basePath)) {
    $endpoint = substr($endpoint, strlen($basePath));
}
$endpoint = rtrim($endpoint, '/') ?: '/';
$key = "$method $endpoint";

$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true) ?? [];

// Autenticación para endpoints protegidos
$publicEndpoints = ['POST /login'];

if (isset($routes[$key])) {
    if (!in_array($key, $publicEndpoints)) {
        $jwtPayload = verify_jwt($jwtSecret);
        if (!$jwtPayload) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Token inválido o ausente']);
            exit;
        }
    }
    $response = $routes[$key]($request);
    http_response_code($response['status'] ?? 200);
    header('Content-Type: application/json');
    echo json_encode($response['body'] ?? $response);
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Endpoint not found']);
}
