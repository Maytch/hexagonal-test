<?php

namespace App\Domain\Entity\Raid\Repository;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\RaidTeam;
use Symfony\Component\Uid\UuidV4;

interface IRaidTeamRepository
{
    public function save(RaidTeam $raidTeam): void;
    public function findOneById(UuidV4 $id): ?RaidTeam;
    public function findForRaid(Raid $raid): array;
}