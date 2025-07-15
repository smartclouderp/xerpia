<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Accounting\Domain\Entity\Account;
use Xerpia\Modules\Accounting\Domain\Repository\AccountRepositoryInterface;

class MariaDbAccountRepository implements AccountRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM accounts');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $accounts = [];
        foreach ($rows as $row) {
            $accounts[] = new Account($row['id'], $row['code'], $row['name'], $row['parent_id'], $row['type']);
        }
        return $accounts;
    }

    public function findById(int $id): ?Account
    {
        $stmt = $this->pdo->prepare('SELECT * FROM accounts WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new Account($row['id'], $row['code'], $row['name'], $row['parent_id'], $row['type']);
    }

    public function create(Account $account): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO accounts (code, name, parent_id, type) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $account->getCode(),
            $account->getName(),
            $account->getParentId(),
            $account->getType()
        ]);
    }

    public function update(Account $account): bool
    {
        $stmt = $this->pdo->prepare('UPDATE accounts SET code = ?, name = ?, parent_id = ?, type = ? WHERE id = ?');
        return $stmt->execute([
            $account->getCode(),
            $account->getName(),
            $account->getParentId(),
            $account->getType(),
            $account->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM accounts WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
