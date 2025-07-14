<?php
namespace Xerpia\Modules\Provider\Infrastructure\Persistence;

use Xerpia\Modules\Provider\Domain\Entity\Provider;
use PDO;

class MariaDbProviderListRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllPaginated(int $page, int $limit, ?string $search = null): array
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        $where = '';
        if ($search) {
            $where = "WHERE business_name LIKE ? OR tax_id LIKE ? OR contact_name LIKE ?";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        $stmt = $this->pdo->prepare("SELECT * FROM providers $where LIMIT ? OFFSET ?");
        $params[] = $limit;
        $params[] = $offset;
        $stmt->execute($params);
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
