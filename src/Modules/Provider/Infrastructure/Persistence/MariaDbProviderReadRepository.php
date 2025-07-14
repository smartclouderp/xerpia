<?php
namespace Xerpia\Modules\Provider\Infrastructure\Persistence;

use Xerpia\Modules\Provider\Domain\Entity\Provider;
use Xerpia\Modules\Provider\Domain\Repository\ProviderReadRepositoryInterface;
use PDO;

class MariaDbProviderReadRepository implements ProviderReadRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $id): ?Provider
    {
        $stmt = $this->pdo->prepare('SELECT * FROM providers WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new Provider(
            $row['id'],
            $row['business_name'],
            $row['tax_id'],
            $row['address'],
            $row['contact_name'],
            $row['contact_email'],
            $row['contact_phone']
        );
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM providers');
        $providers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $providers[] = new Provider(
                $row['id'],
                $row['business_name'],
                $row['tax_id'],
                $row['address'],
                $row['contact_name'],
                $row['contact_email'],
                $row['contact_phone']
            );
        }
        return $providers;
    }
}
