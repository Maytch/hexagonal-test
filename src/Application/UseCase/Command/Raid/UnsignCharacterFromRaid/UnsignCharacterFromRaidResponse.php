<?php

namespace App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid;

use App\Domain\Entity\Raid\CharacterSignup;
use App\Domain\Entity\Raid\RaidTeamMember;

class UnsignCharacterFromRaidResponse
{
    public function __construct(
        private ?CharacterSignup $characterSignup,
        private ?RaidTeamMember $raidTeamMember
    )
    {
    }

    public function getCharacterSignup(): ?CharacterSignup
    {
        return $this->characterSignup;
    }

    public function getRaidTeamMember(): ?RaidTeamMember
    {
        return $this->raidTeamMember;
    }
}