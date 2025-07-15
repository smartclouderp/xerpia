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
    public function findByAccountId(int $accountId, ?string $dateFrom = null, ?string $dateTo = null): array;
    public function findByFilters(?string $dateFrom = null, ?string $dateTo = null, ?int $accountId = null, ?int $thirdPartyId = null): array;
}
