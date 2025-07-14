<?php
namespace Xerpia\Modules\Provider\Infrastructure\Persistence;

use Xerpia\Modules\Provider\Domain\Entity\Provider;
use Xerpia\Modules\Provider\Domain\Repository\ProviderRepositoryInterface;
use PDO;

class MariaDbProviderRepositoryExtended implements ProviderRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Provider $provider): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO providers (business_name, tax_id, address, contact_name, contact_email, contact_phone) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $provider->getBusinessName(),
            $provider->getTaxId(),
            $provider->getAddress(),
            $provider->getContactName(),
            $provider->getContactEmail(),
            $provider->getContactPhone()
        ]);
    }

    public function update(Provider $provider): bool
    {
        $stmt = $this->pdo->prepare('UPDATE providers SET business_name = ?, tax_id = ?, address = ?, contact_name = ?, contact_email = ?, contact_phone = ? WHERE id = ?');
        return $stmt->execute([
            $provider->getBusinessName(),
            $provider->getTaxId(),
            $provider->getAddress(),
            $provider->getContactName(),
            $provider->getContactEmail(),
            $provider->getContactPhone(),
            $provider->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM providers WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
