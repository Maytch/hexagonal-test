<?php 

namespace App\Infrastructure\Raid\Repository;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\RaidTeamMember;
use App\Domain\Entity\Raid\Repository\IRaidTeamMemberRepository;
use App\Domain\ValueObject\RaidTeamMemberStatus;
use Symfony\Component\Uid\UuidV4;

class InMemoryRaidTeamMemberRepository implements IRaidTeamMemberRepository
{
    protected array $raidTeamMembers = [];

    public function save(RaidTeamMember $raidTeamMember): void
    {
        $this->raidTeamMembers[$raidTeamMember->getId()->toRfc4122()] = $raidTeamMember;
    }

    public function findOneById(UuidV4 $id): ?RaidTeamMember
    {
        return $this->raidTeamMembers[$id->toRfc4122()] ?? null;
    }

    public function findOneByRaidAndCharacter(Raid $raid, Character $character): ?RaidTeamMember
    {
        foreach ($this->raidTeamMembers as $raidTeamMember) {
            if (
                $raidTeamMember->getRaidTeam()->getRaid()->getId() === $raid->getId() &&
                $raidTeamMember->getCharacter()->getId() === $character->getId()
            ) {
                return $raidTeamMember;
            }
        }

        return null;
    }

    public function findForRaidTeam(RaidTeam $raidTeam): array
    {
        return array_filter($this->raidTeamMembers, function ($raidTeamMember) use($raidTeam) {
            return $raidTeamMember->getRaidTeam() === $raidTeam;
        });
    }

    public function findForRaidTeamAndStatus(RaidTeam $raidTeam, RaidTeamMemberStatus $raidTeamMemberStatus): array
    {
        return array_filter($this->raidTeamMembers, function ($raidTeamMember) use($raidTeam, $raidTeamMemberStatus) {
            return $raidTeamMember->getRaidTeam() === $raidTeam &&
                $raidTeamMember->getRaidTeamMemberStatus() === $raidTeamMemberStatus;
        });
    }
}