<?php
namespace Xerpia\Modules\Accounting\Infrastructure\Persistence;

use PDO;
use Xerpia\Modules\Accounting\Domain\Entity\JournalEntryLine;
use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class MariaDbJournalEntryLineRepository implements JournalEntryLineRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(JournalEntryLine $line): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO journal_entry_lines (journal_entry_id, account_id, debit, credit, description) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([
            $line->getJournalEntryId(),
            $line->getAccountId(),
            $line->getDebit(),
            $line->getCredit(),
            $line->getDescription()
        ]);
    }

    public function update(JournalEntryLine $line): bool
    {
        $stmt = $this->pdo->prepare('UPDATE journal_entry_lines SET account_id = ?, debit = ?, credit = ?, description = ? WHERE id = ?');
        return $stmt->execute([
            $line->getAccountId(),
            $line->getDebit(),
            $line->getCredit(),
            $line->getDescription(),
            $line->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM journal_entry_lines WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function findById(int $id): ?JournalEntryLine
    {
        $stmt = $this->pdo->prepare('SELECT * FROM journal_entry_lines WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new JournalEntryLine($row['id'], $row['journal_entry_id'], $row['account_id'], $row['debit'], $row['credit'], $row['description']);
    }

    public function findByJournalEntryId(int $journalEntryId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM journal_entry_lines WHERE journal_entry_id = ?');
        $stmt->execute([$journalEntryId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lines = [];
        foreach ($rows as $row) {
            $lines[] = new JournalEntryLine($row['id'], $row['journal_entry_id'], $row['account_id'], $row['debit'], $row['credit'], $row['description']);
        }
        return $lines;
    }
}
