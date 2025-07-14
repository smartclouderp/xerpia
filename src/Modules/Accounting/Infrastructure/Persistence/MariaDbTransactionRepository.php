<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use Xerpia\Modules\Accounting\Domain\Entity\Transaction;
use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;
use PDO;

class MariaDbTransactionRepository implements TransactionRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function save(Transaction $transaction): void {
        $stmt = $this->pdo->prepare('INSERT INTO transactions (amount, description, date) VALUES (?, ?, ?)');
        $stmt->execute([
            $transaction->getAmount(),
            $transaction->getDescription(),
            $transaction->getDate()->format('Y-m-d H:i:s')
        ]);
    }

    public function findById(int $id): ?Transaction {
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Transaction($row['amount'], $row['description'], new \DateTime($row['date']));
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM transactions');
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = new Transaction($row['amount'], $row['description'], new \DateTime($row['date']));
        }
        return $transactions;
    }
}
