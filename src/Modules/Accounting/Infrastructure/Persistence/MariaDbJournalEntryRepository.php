<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Accounting\Domain\Entity\JournalEntry;
use Xerpia\Modules\Accounting\Domain\Entity\JournalEntryLine;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryRepositoryInterface;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class MariaDbJournalEntryRepository implements JournalEntryRepositoryInterface
{
    private PDO $pdo;
    private JournalEntryLineRepositoryInterface $lineRepo;

    public function __construct(PDO $pdo, JournalEntryLineRepositoryInterface $lineRepo)
    {
        $this->pdo = $pdo;
        $this->lineRepo = $lineRepo;
    }

    public function create(JournalEntry $entry): bool
    {
        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare('INSERT INTO journal_entries (date, description, third_party_id) VALUES (?, ?, ?)');
        $ok = $stmt->execute([
            $entry->getDate(),
            $entry->getDescription(),
            $entry->getThirdPartyId()
        ]);
        if (!$ok) {
            $this->pdo->rollBack();
            return false;
        }
        $entryId = (int)$this->pdo->lastInsertId();
        foreach ($entry->getLines() as $line) {
            $lineObj = new JournalEntryLine(0, $entryId, $line->getAccountId(), $line->getDebit(), $line->getCredit(), $line->getDescription());
            if (!$this->lineRepo->create($lineObj)) {
                $this->pdo->rollBack();
                return false;
            }
        }
        $this->pdo->commit();
        return true;
    }

    public function update(JournalEntry $entry): bool
    {
        // Implementar según reglas de negocio (actualización de líneas, etc.)
        return false;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM journal_entries WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function findById(int $id): ?JournalEntry
    {
        $stmt = $this->pdo->prepare('SELECT * FROM journal_entries WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        $lines = $this->lineRepo->findByJournalEntryId($row['id']);
        return new JournalEntry($row['id'], $row['date'], $row['description'], $row['third_party_id'], $lines);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM journal_entries');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $entries = [];
        foreach ($rows as $row) {
            $lines = $this->lineRepo->findByJournalEntryId($row['id']);
            $entries[] = new JournalEntry($row['id'], $row['date'], $row['description'], $row['third_party_id'], $lines);
        }
        return $entries;
    }
}
