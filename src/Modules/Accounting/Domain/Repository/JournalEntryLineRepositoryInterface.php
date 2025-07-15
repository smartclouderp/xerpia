<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\JournalEntryLine;

interface JournalEntryLineRepositoryInterface
{
    public function create(JournalEntryLine $line): bool;
    public function update(JournalEntryLine $line): bool;
    public function delete(int $id): bool;
    public function findById(int $id): ?JournalEntryLine;
    public function findByJournalEntryId(int $journalEntryId): array;
}
