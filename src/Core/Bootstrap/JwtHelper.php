<?php
namespace Xerpia\Core\Bootstrap;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper {
    public static function verify($jwtSecret): array|false {
        $headers = getallheaders();
        if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
            return false;
        }
        $jwt = trim(substr($headers['Authorization'], 7));
        try {
            return (array)JWT::decode($jwt, new Key($jwtSecret, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
