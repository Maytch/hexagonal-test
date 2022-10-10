<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeamMember;

use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\RaidTeamMember;

class CreateRaidTeamMemberResponse
{
    public function __construct(
        private RaidTeamMember $raidTeamMember
    )
    {
    }

    public function getRaidTeamMember(): RaidTeamMember
    {
        return $this->raidTeamMember;
    }
}