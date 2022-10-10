<?php 

namespace App\Infrastructure\Raid\Repository;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\Repository\IRaidRepository;
use Symfony\Component\Uid\UuidV4;

class InMemoryRaidRepository implements IRaidRepository
{
    protected array $raids = [];

    public function save(Raid $raid): void
    {
        $this->raids[$raid->getId()->toRfc4122()] = $raid;
    }

    public function findOneById(UuidV4 $id): ?Raid 
    {
        return $this->raids[$id->toRfc4122()] ?? null;
    }
}