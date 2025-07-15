<?php
namespace Xerpia\Modules\User\Infrastructure\Persistence;

use Xerpia\Modules\User\Domain\Entity\User;
use Xerpia\Modules\User\Domain\Repository\UserWriteRepositoryInterface;
use PDO;

class MariaDbUserWriteRepository implements UserWriteRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(User $user, array $roles): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$user->getUsername(), $user->getPasswordHash()]);
            $userId = $this->pdo->lastInsertId();
            foreach ($roles as $roleId) {
                $stmtRole = $this->pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)');
                $stmtRole->execute([$userId, $roleId]);
            }
            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];
        if (isset($data['username'])) {
            $fields[] = 'username = ?';
            $params[] = $data['username'];
        }
        if (isset($data['password'])) {
            $fields[] = 'password_hash = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (isset($data['email'])) {
            $fields[] = 'email = ?';
            $params[] = $data['email'];
        }
        if (empty($fields)) {
            return false;
        }
        $params[] = $id;
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
