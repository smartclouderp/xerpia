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

    public function findByAccountId(int $accountId, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $query = 'SELECT * FROM journal_entry_lines jel INNER JOIN journal_entries je ON jel.journal_entry_id = je.id WHERE jel.account_id = ?';
        $params = [$accountId];
        if ($dateFrom) {
            $query .= ' AND je.date >= ?';
            $params[] = $dateFrom;
        }
        if ($dateTo) {
            $query .= ' AND je.date <= ?';
            $params[] = $dateTo;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lines = [];
        foreach ($rows as $row) {
            $lines[] = new JournalEntryLine($row['id'], $row['journal_entry_id'], $row['account_id'], $row['debit'], $row['credit'], $row['description']);
        }
        return $lines;
    }

    public function findByFilters(?string $dateFrom = null, ?string $dateTo = null, ?int $accountId = null, ?int $thirdPartyId = null): array
    {
        $query = 'SELECT jel.* FROM journal_entry_lines jel INNER JOIN journal_entries je ON jel.journal_entry_id = je.id WHERE 1=1';
        $params = [];
        if ($dateFrom) {
            $query .= ' AND je.date >= ?';
            $params[] = $dateFrom;
        }
        if ($dateTo) {
            $query .= ' AND je.date <= ?';
            $params[] = $dateTo;
        }
        if ($accountId) {
            $query .= ' AND jel.account_id = ?';
            $params[] = $accountId;
        }
        if ($thirdPartyId) {
            $query .= ' AND je.third_party_id = ?';
            $params[] = $thirdPartyId;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lines = [];
        foreach ($rows as $row) {
            $lines[] = new JournalEntryLine($row['id'], $row['journal_entry_id'], $row['account_id'], $row['debit'], $row['credit'], $row['description']);
        }
        return $lines;
    }
}
