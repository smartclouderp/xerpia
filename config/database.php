<?php
// config/database.php
return [
    'host' => getenv('DB_HOST') ?: 'db',
    'db'   => getenv('DB_NAME') ?: 'xerpia',
    'user' => getenv('DB_USER') ?: 'xerpia',
    'pass' => getenv('DB_PASS') ?: 'xerpia123',
];
