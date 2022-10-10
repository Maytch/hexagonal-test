<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeamMember;

use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\ValueObject\RaidTeamMemberStatus;

class CreateRaidTeamMemberCommand
{
    /**
     * @param RaidTeam $raidTeam
     * @param Character $character
     * @param RaidTeamMemberStatus $raidTeamMemberStatus
     */
    public function __construct(
        private RaidTeam $raidTeam,
        private Character $character,
        private RaidTeamMemberStatus $raidTeamMemberStatus,
    )
    {
        
    }

    /**
     * @return RaidTeam
     */
    public function getRaidTeam(): RaidTeam
    {
        return $this->raidTeam;
    }

    /**
     * @return Character
     */
    public function getCharcter(): Character
    {
        return $this->character;
    }

    /**
     * @return RaidTeamMemberStatus
     */
    public function getRaidTeamMemberStatus(): RaidTeamMemberStatus 
    {
        return $this->raidTeamMemberStatus;
    }
}