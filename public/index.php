
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Xerpia\Core\Bootstrap\EnvLoader;
use Xerpia\Core\Database\Connection;
use Xerpia\Modules\Accounting\Adapter\Web\ReportsControllerFactory;
use Xerpia\Core\Bootstrap\Router;

// Cargar .env
EnvLoader::load(__DIR__ . '/..');

$config = require __DIR__ . '/../config/database.php';
$db = new Connection($config['host'], $config['db'], $config['user'], $config['pass']);

$jwtSecret = 'TU_SECRETO_JWT';

// Instanciar controladores y dependencias
$controllers = (require __DIR__ . '/../config/dependencies.php')($db, $jwtSecret);
$reportsControllers = ReportsControllerFactory::create($db->getPdo());

// Rutas
if (!isset($routesSwagger) || !is_array($routesSwagger)) {
    $routesSwagger = [];
}
$routes = array_merge($routesSwagger, (require __DIR__ . '/../config/routes.php')($controllers, $reportsControllers));

// Endpoints públicos
$publicEndpoints = ['POST /login'];

// Despachar petición
Router::dispatch($routes, $publicEndpoints, $jwtSecret);
