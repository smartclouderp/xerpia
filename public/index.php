<?php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use Xerpia\Core\Database\Connection;

$config = require __DIR__ . '/../config/database.php';
$db = new Connection($config['host'], $config['db'], $config['user'], $config['pass']);

// Aquí puedes enrutar las peticiones y cargar módulos
// Ejemplo modular:
echo "Xerpia ERP inicializado. Conexión a DB exitosa.";
