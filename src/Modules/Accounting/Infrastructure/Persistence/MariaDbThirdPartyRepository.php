<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Accounting\Domain\Entity\ThirdParty;
use Xerpia\Modules\Accounting\Domain\Repository\ThirdPartyRepositoryInterface;

class MariaDbThirdPartyRepository implements ThirdPartyRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(ThirdParty $thirdParty): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO third_parties (name, document, email, phone) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $thirdParty->getName(),
            $thirdParty->getDocument(),
            $thirdParty->getEmail(),
            $thirdParty->getPhone()
        ]);
    }

    public function update(ThirdParty $thirdParty): bool
    {
        $stmt = $this->pdo->prepare('UPDATE third_parties SET name = ?, document = ?, email = ?, phone = ? WHERE id = ?');
        return $stmt->execute([
            $thirdParty->getName(),
            $thirdParty->getDocument(),
            $thirdParty->getEmail(),
            $thirdParty->getPhone(),
            $thirdParty->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM third_parties WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function findById(int $id): ?ThirdParty
    {
        $stmt = $this->pdo->prepare('SELECT * FROM third_parties WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new ThirdParty($row['id'], $row['name'], $row['document'], $row['email'], $row['phone']);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM third_parties');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $thirdParties = [];
        foreach ($rows as $row) {
            $thirdParties[] = new ThirdParty($row['id'], $row['name'], $row['document'], $row['email'], $row['phone']);
        }
        return $thirdParties;
    }
}
