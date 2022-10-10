<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeam;

use App\Domain\Entity\Raid\RaidTeam;

class CreateRaidTeamResponse
{
    public function __construct(
        private RaidTeam $raidTeam
    )
    {
    }

    public function getRaidTeam(): RaidTeam
    {
        return $this->raidTeam;
    }
}