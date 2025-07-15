<?php
namespace Xerpia\Core\Bootstrap;

class Router {
    public static function dispatch(array $routes, array $publicEndpoints, $jwtSecret) {
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

        if (isset($routes[$key])) {
            if (!in_array($key, $publicEndpoints)) {
                $jwtPayload = JwtHelper::verify($jwtSecret);
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
    }
}
