<?php

namespace App\Domain\Entity\Raid\Repository;

use App\Domain\Entity\Raid\Raid;
use Symfony\Component\Uid\UuidV4;

interface IRaidRepository
{
    public function save(Raid $raid): void;
    public function findOneById(UuidV4 $id): ?Raid;
}