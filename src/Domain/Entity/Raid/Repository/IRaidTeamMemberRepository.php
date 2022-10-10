<?php

namespace App\Domain\Entity\Raid\Repository;

use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\RaidTeamMember;
use App\Domain\ValueObject\RaidTeamMemberStatus;
use Symfony\Component\Uid\UuidV4;

interface IRaidTeamMemberRepository
{
    public function save(RaidTeamMember $raidTeamMember): void;
    public function findOneById(UuidV4 $id): ?RaidTeamMember;
    public function findOneByRaidAndCharacter(Raid $raid, Character $character): ?RaidTeamMember;
    public function findForRaidTeam(RaidTeam $raidTeam): array;
    public function findForRaidTeamAndStatus(RaidTeam $raidTeam, RaidTeamMemberStatus $raidTeamMemberStatus): array;
}