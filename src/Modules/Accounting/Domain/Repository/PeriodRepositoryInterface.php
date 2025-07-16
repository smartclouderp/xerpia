<?php
namespace Xerpia\Modules\Accounting\Domain\Repository;

use Xerpia\Modules\Accounting\Domain\Entity\Period;

interface PeriodRepositoryInterface
{
    public function findOpenByDate(string $date): ?Period;
    public function findAll(): array;
    public function save(Period $period): void;
    public function close(int $id): void;
}
