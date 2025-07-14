<?php
// config/database.php
return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'db'   => getenv('DB_NAME') ?: 'xerpia',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
];
