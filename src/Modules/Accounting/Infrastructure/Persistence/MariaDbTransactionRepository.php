<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use Xerpia\Modules\Accounting\Domain\Entity\Transaction;
use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;
use PDO;

class MariaDbTransactionRepository implements TransactionRepositoryInterface {
    public function getPdo(): PDO {
        return $this->pdo;
    }
    public function findByThirdPartyAndDateRange($third_party_id, $date_from = null, $date_to = null): array {
        $sql = 'SELECT * FROM transactions WHERE third_party_id = ?';
        $params = [$third_party_id];
        if ($date_from) {
            $sql .= ' AND date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' ORDER BY date ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = [
                'id' => $row['id'],
                'amount' => $row['amount'],
                'description' => $row['description'],
                'date' => $row['date'],
                'account_id' => $row['account_id'] ?? null,
                'third_party_id' => $row['third_party_id'] ?? null
            ];
        }
        return $transactions;
    }
    public function findAllByDateRange($date_from = null, $date_to = null): array {
        $sql = 'SELECT * FROM transactions WHERE 1=1';
        $params = [];
        if ($date_from) {
            $sql .= ' AND date >= ?';
            $params[] = $date_from;
        }
        if ($date_to) {
            $sql .= ' AND date <= ?';
            $params[] = $date_to;
        }
        $sql .= ' ORDER BY date ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = [
                'id' => $row['id'],
                'amount' => $row['amount'],
                'description' => $row['description'],
                'date' => $row['date'],
                'account_id' => $row['account_id'] ?? null,
                'third_party_id' => $row['third_party_id'] ?? null
            ];
        }
        return $transactions;
    }
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
