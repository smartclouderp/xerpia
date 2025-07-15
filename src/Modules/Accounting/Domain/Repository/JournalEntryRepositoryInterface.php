<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\JournalEntry;

interface JournalEntryRepositoryInterface
{
    public function create(JournalEntry $entry): bool;
    public function update(JournalEntry $entry): bool;
    public function delete(int $id): bool;
    public function findById(int $id): ?JournalEntry;
    public function findAll(): array;
}
