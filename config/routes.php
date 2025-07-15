<?php
// Definición de rutas principales
return function($controllers, $reportsControllers) {
    return [
        'POST /login' => fn($req) => $controllers['loginController']->login($req),
        'POST /users' => fn($req) => $controllers['registerUserController']->register($req),
        'PUT /users' => fn($req) => ($id = $req['id'] ?? 0) > 0
            ? $controllers['updateUserController']->update((int)$id, $req)
            : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
        'DELETE /users' => fn($req) => ($id = $req['id'] ?? 0) > 0
            ? $controllers['deleteUserController']->delete((int)$id)
            : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
        'GET /users' => fn() => $controllers['getAllUsersController']->get(),
        'GET /users/id' => fn($req) => ($id = $req['id'] ?? 0) > 0
            ? $controllers['getUserByIdController']->get((int)$id)
            : ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']],
        // ...otras rutas...
        'GET /reports/balance-sheet' => fn($req) => $reportsControllers['getBalanceSheetController']->get($req['date_to'] ?? null),
        'GET /reports/transactions' => fn($req) => $reportsControllers['getTransactionsController']->get(
            $req['date_from'] ?? null,
            $req['date_to'] ?? null,
            isset($req['account_id']) ? (int)$req['account_id'] : null,
            isset($req['third_party_id']) ? (int)$req['third_party_id'] : null
        ),
        // ...rutas de reportes...
    ];
};
