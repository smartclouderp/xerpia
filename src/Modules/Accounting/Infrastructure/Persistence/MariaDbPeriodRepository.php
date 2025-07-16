<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Accounting\Domain\Entity\Period;
use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;

class MariaDbPeriodRepository implements PeriodRepositoryInterface
{
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function findOpenByDate(string $date): ?Period
    {
        $stmt = $this->pdo->prepare('SELECT * FROM periods WHERE status = "open" AND date_from <= ? AND date_to >= ? LIMIT 1');
        $stmt->execute([$date, $date]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Period($row['id'], $row['name'], $row['date_from'], $row['date_to'], $row['status']);
    }
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM periods ORDER BY date_from DESC');
        $periods = [];
        while ($row = $stmt->fetch()) {
            $periods[] = new Period($row['id'], $row['name'], $row['date_from'], $row['date_to'], $row['status']);
        }
        return $periods;
    }
    public function save(Period $period): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO periods (name, date_from, date_to, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$period->getName(), $period->getDateFrom(), $period->getDateTo(), $period->getStatus()]);
    }
    public function close(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE periods SET status = "closed" WHERE id = ?');
        $stmt->execute([$id]);
    }
    public function findById(int $id): ?Period
    {
        $stmt = $this->pdo->prepare('SELECT * FROM periods WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Period($row['id'], $row['name'], $row['date_from'], $row['date_to'], $row['status']);
    }
}
