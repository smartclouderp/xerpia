<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Xerpia\Modules\User\Adapter\Web\LoginController;
use Xerpia\Modules\User\Application\UseCase\LoginUser;
use Xerpia\Modules\User\Infrastructure\Persistence\MariaDbUserRepository;

// Configuración de la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=xerpia', 'usuario', 'contraseña');

// Clave secreta para JWT
$jwtSecret = 'TU_SECRETO_JWT';

// Instancias
$userRepository = new MariaDbUserRepository($pdo);
$loginUser = new LoginUser($userRepository, $jwtSecret);
$controller = new LoginController($loginUser);

// Obtener datos del request (asumiendo JSON)
$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true) ?? [];

$response = $controller->login($request);

http_response_code($response['status']);
header('Content-Type: application/json');
echo json_encode($response['body']);
