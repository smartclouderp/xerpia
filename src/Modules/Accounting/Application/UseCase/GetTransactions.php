<?php
namespace Xerpia\Modules\Accounting\Application\UseCase;

use Xerpia\Modules\Accounting\Domain\Repository\JournalEntryLineRepositoryInterface;

class GetTransactions
{
    private JournalEntryLineRepositoryInterface $lineRepository;

    public function __construct(JournalEntryLineRepositoryInterface $lineRepository)
    {
        $this->lineRepository = $lineRepository;
    }

    public function execute(?string $dateFrom = null, ?string $dateTo = null, ?int $accountId = null, ?int $thirdPartyId = null): array
    {
        return $this->lineRepository->findByFilters($dateFrom, $dateTo, $accountId, $thirdPartyId);
    }
}
