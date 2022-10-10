<?php 

namespace App\Domain\Entity\Raid;

use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\Raid;
use App\Domain\ValueObject\RaidTeamMemberStatus;
use Symfony\Component\Uid\UuidV4;

class RaidTeamMember
{
    /**
     * @param UuidV4 $id
     * @param RaidTeam $raidTeam
     * @param Character $character
     * @param RaidTeamMemberStatus $raidTeamMemberStatus
     */
    public function __construct(
        private UuidV4 $id,
        private RaidTeam $raidTeam,
        private Character $character,
        private RaidTeamMemberStatus $raidTeamMemberStatus,
    )
    {
    }

    /**
     * @return UuidV4
     */
    public function getId(): UuidV4
    {
        return $this->id;
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
    public function getCharacter(): Character
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

    /**
     * @return RaidTeamMember
     */
    public function setRaidTeamMemberStatus(RaidTeamMemberStatus $raidTeamMemberStatus): RaidTeamMember
    {
        $this->raidTeamMemberStatus = $raidTeamMemberStatus;
        return $this;
    }
}