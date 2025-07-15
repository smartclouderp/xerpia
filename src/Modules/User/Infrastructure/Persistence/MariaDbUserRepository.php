<?php
namespace Xerpia\Modules\User\Infrastructure\Persistence;

use Xerpia\Modules\User\Domain\Entity\User;
use Xerpia\Modules\User\Domain\Repository\UserRepositoryInterface;
use PDO;

class MariaDbUserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User($row['id'], $row['username'], $row['password_hash']);
    }
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, username, email FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, username, email FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
