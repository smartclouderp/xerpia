<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\RegisterTransaction;

class TransactionController {
    private RegisterTransaction $registerTransaction;

    public function __construct(RegisterTransaction $registerTransaction) {
        $this->registerTransaction = $registerTransaction;
    }

    public function register(array $data)
    {
        try {
            $amount = $data['amount'];
            $description = $data['description'];
            $date = new \DateTime($data['date']);
            $this->registerTransaction->execute($amount, $description, $date);
            return [
                'status' => 201,
                'body' => ['message' => 'Transacción registrada']
            ];
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'body' => ['error' => $e->getMessage()]
            ];
        }
    }
}
