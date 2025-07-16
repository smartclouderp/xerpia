<?php
// Definición de rutas principales
return function($controllers, $reportsControllers) {
    /**
     * @openapi
     * /login:
     *   post:
     *     summary: Login de usuario
     *     description: Autentica al usuario y devuelve un JWT.
     *     tags:
     *       - Usuarios
     *     requestBody:
     *       required: true
     *       content:
     *         application/json:
     *           schema:
     *             type: object
     *             required:
     *               - username
     *               - password
     *             properties:
     *               username:
     *                 type: string
     *               password:
     *                 type: string
     *     responses:
     *       200:
     *         description: JWT generado
     *         content:
     *           application/json:
     *             schema:
     *               type: object
     *               properties:
     *                 token:
     *                   type: string
     */
    return [
        'POST /users' => fn($req) => $controllers['registerUserController']->register($req),
        'POST /login' => fn($req) => $controllers['loginController']->login($req),
        'PUT /users' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['updateUserController']->update((int)$id, $req);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        'DELETE /users' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['deleteUserController']->delete((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        'GET /users' => fn() => $controllers['getAllUsersController']->get(),
        'GET /users/id' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['getUserByIdController']->get((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        // Productos
        'POST /products' => fn($req) => $controllers['productController']->register($req),
        'GET /products' => fn($req) => $controllers['productListController']->list($req),
        'PUT /products' => fn($req) => $controllers['updateProductController']->update($req),
        'DELETE /products' => fn($req) => $controllers['deleteProductController']->delete($req),
        // Proveedores
        'POST /providers' => fn($req) => $controllers['registerProviderController']->register($req),
        'GET /providers' => fn($req) => $controllers['providerQueryController']->get($req),
        'GET /providers/list' => fn($req) => $controllers['providerListController']->get($req),
        'PUT /providers' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['updateProviderController']->update((int)$id, $req);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']];
        },
        'DELETE /providers' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['deleteProviderController']->delete((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']];
        },
        // ...otras rutas...
        'GET /reports/balance-sheet' => fn($req) => $reportsControllers['getBalanceSheetController']->get($req['date_to'] ?? null),
        'GET /reports/account-movements' => fn($req) => $controllers['getAccountMovementsReportController']->get($req),
        'GET /reports/export' => function($req) use ($controllers) {
            $format = $req['format'] ?? 'csv';
            return $controllers['exportReportController']->export($format, $req);
        },
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
        'GET /reports/income-statement' => function($req) use ($reportsControllers) {
            return $reportsControllers['getIncomeStatementController']->get(
                $req['date_from'] ?? null,
                $req['date_to'] ?? null
            );
        },
        'GET /reports/journal' => fn($req) => $controllers['getJournalReportController']->get($req['date_from'] ?? null, $req['date_to'] ?? null),
        // --- Periodos contables ---
        'POST /periods' => fn($req) => $controllers['createPeriodController']->create($req),
        'GET /periods' => fn() => $controllers['listPeriodsController']->list(),
        'POST /periods/close' => fn($req) => $controllers['closePeriodController']->close($req),
        'GET /periods/validate-date' => fn($req) => $controllers['validateDateInOpenPeriodController']->validate($req['date'] ?? null),
        'GET /reports/period-close' => fn($req) => $controllers['getPeriodCloseReportController']->get($req),
        // ...rutas de reportes...
    ];
        /**
         * @openapi
         * /reports/third-party:
         *   get:
         *     summary: Informe de movimientos y saldo por tercero
         *     description: Devuelve los movimientos y saldo de un tercero en un rango de fechas.
         *     tags:
         *       - Contabilidad
         *     parameters:
         *       - in: query
         *         name: third_party_id
         *         schema:
         *           type: integer
         *         required: true
         *         description: ID del tercero
         *       - in: query
        /**
         * @openapi
         * /reports/third-party:
         *   get:
         *     summary: Informe de movimientos y saldo por tercero
         *     description: Devuelve los movimientos y saldo de un tercero en un rango de fechas.
         *     tags:
         *       - Contabilidad
         *     parameters:
         *       - in: query
         *         name: third_party_id
         *         schema:
         *           type: integer
         *         required: true
         *         description: ID del tercero
         *       - in: query
         *         name: date_from
         *         schema:
         *           type: string
         *           format: date
         *         required: false
         *         description: Fecha inicial (YYYY-MM-DD)
         *       - in: query
         *         name: date_to
         *         schema:
         *           type: string
         *           format: date
         *         required: false
         *         description: Fecha final (YYYY-MM-DD)
         *     responses:
         *       200:
<?php
// Definición de rutas principales
return function($controllers, $reportsControllers) {
    /**
     * @openapi
     * /reports/third-party:
     *   get:
     *     summary: Informe de movimientos y saldo por tercero
     *     description: Devuelve los movimientos y saldo de un tercero en un rango de fechas.
     *     tags:
     *       - Contabilidad
     *     parameters:
     *       - in: query
     *         name: third_party_id
     *         schema:
     *           type: integer
     *         required: true
     *         description: ID del tercero
     *       - in: query
     *         name: date_from
     *         schema:
     *           type: string
     *           format: date
     *         required: false
     *         description: Fecha inicial (YYYY-MM-DD)
     *       - in: query
     *         name: date_to
     *         schema:
     *           type: string
     *           format: date
     *         required: false
     *         description: Fecha final (YYYY-MM-DD)
     *     responses:
     *       200:
     *         description: Informe de movimientos y saldo
     *         content:
     *           application/json:
     *             schema:
     *               type: object
     *               properties:
     *                 third_party_id:
     *                   type: integer
     *                 saldo:
     *                   type: number
     *                 movimientos:
     *                   type: array
     *                   items:
     *                     type: object
     *                     properties:
     *                       id:
     *                         type: integer
     *                       amount:
     *                         type: number
     *                       description:
     *                         type: string
     *                       date:
     *                         type: string
     *                         format: date-time
     *                       account_id:
     *                         type: integer
     *                       third_party_id:
     *                         type: integer
     */
    /**
     * @openapi
     * /transactions:
     *   post:
     *     summary: Registrar una transacción contable
     *     description: Registra una transacción solo si la fecha está en un periodo contable abierto.
     *     tags:
     *       - Contabilidad
     *     requestBody:
     *       required: true
     *       content:
     *         application/json:
     *           schema:
     *             type: object
     *             required:
     *               - amount
     *               - description
     *               - date
     *             properties:
     *               amount:
     *                 type: number
     *                 example: 1000.50
     *               description:
     *                 type: string
     *                 example: "Pago de factura"
     *               date:
     *                 type: string
     *                 format: date
     *                 example: "2025-07-15"
     *     responses:
     *       201:
     *         description: Transacción registrada
     *         content:
     *           application/json:
     *             schema:
     *               type: object
     *               properties:
     *                 message:
     *                   type: string
     *                   example: "Transacción registrada"
     *       400:
     *         description: Error de validación o periodo cerrado
     *         content:
     *           application/json:
     *             schema:
     *               type: object
     *               properties:
     *                 error:
     *                   type: string
     *                   example: "La fecha de la transacción no está en un periodo contable abierto."
     */
    /**
     * @openapi
     * /reports/journal:
     *   get:
     *     summary: Libro diario
     *     description: Devuelve todas las transacciones en orden cronológico entre dos fechas.
     *     tags:
     *       - Contabilidad
     *     parameters:
     *       - in: query
     *         name: date_from
     *         schema:
     *           type: string
     *           format: date
     *         required: false
     *         description: Fecha inicial (YYYY-MM-DD)
     *       - in: query
     *         name: date_to
     *         schema:
     *           type: string
     *           format: date
     *         required: false
     *         description: Fecha final (YYYY-MM-DD)
     *     responses:
     *       200:
     *         description: Lista de transacciones
     *         content:
     *           application/json:
     *             schema:
     *               type: array
     *               items:
     *                 type: object
     *                 properties:
     *                   id:
     *                     type: integer
     *                   amount:
     *                     type: number
     *                   description:
     *                     type: string
     *                   date:
     *                     type: string
     *                     format: date-time
     *                   account_id:
     *                     type: integer
     *                   third_party_id:
     *                     type: integer
     */
    return [
        'PUT /users' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['updateUserController']->update((int)$id, $req);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        'DELETE /users' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['deleteUserController']->delete((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        'GET /users' => fn() => $controllers['getAllUsersController']->get(),
        'GET /users/id' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['getUserByIdController']->get((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de usuario requerido y válido']];
        },
        // Productos
        'POST /products' => fn($req) => $controllers['productController']->register($req),
        'GET /products' => fn($req) => $controllers['productListController']->list($req),
        'PUT /products' => fn($req) => $controllers['updateProductController']->update($req),
        'DELETE /products' => fn($req) => $controllers['deleteProductController']->delete($req),
        // Proveedores
        'POST /providers' => fn($req) => $controllers['registerProviderController']->register($req),
        'GET /providers' => fn($req) => $controllers['providerQueryController']->get($req),
        'GET /providers/list' => fn($req) => $controllers['providerListController']->get($req),
        'PUT /providers' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['updateProviderController']->update((int)$id, $req);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']];
        },
        'DELETE /providers' => function($req) use ($controllers) {
            $id = $req['id'] ?? 0;
            if ($id > 0) {
                return $controllers['deleteProviderController']->delete((int)$id);
            }
            return ['status' => 400, 'body' => ['error' => 'Id de proveedor requerido y válido']];
        },
        // ...otras rutas...
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
        'GET /reports/income-statement' => function($req) use ($reportsControllers) {
            return $reportsControllers['getIncomeStatementController']->get(
                $req['date_from'] ?? null,
                $req['date_to'] ?? null
            );
        },
        'GET /reports/journal' => fn($req) => $controllers['getJournalReportController']->get($req['date_from'] ?? null, $req['date_to'] ?? null),
        // --- Periodos contables ---
        'POST /periods' => fn($req) => $controllers['createPeriodController']->create($req),
        'GET /periods' => fn() => $controllers['listPeriodsController']->list(),
        'POST /periods/close' => fn($req) => $controllers['closePeriodController']->close($req),
        'GET /periods/validate-date' => fn($req) => $controllers['validateDateInOpenPeriodController']->validate($req['date'] ?? null),
        // ...rutas de reportes...
    ];
};
