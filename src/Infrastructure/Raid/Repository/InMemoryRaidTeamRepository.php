<?php 

namespace App\Infrastructure\Raid\Repository;

use App\Domain\Entity\Raid\CharacterSignup;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\Repository\IRaidTeamRepository;
use Symfony\Component\Uid\UuidV4;

class InMemoryRaidTeamRepository implements IRaidTeamRepository
{
    protected array $raidTeams = [];

    public function save(RaidTeam $raidTeam): void
    {
        $this->raidTeams[$raidTeam->getId()->toRfc4122()] = $raidTeam;
    }

    public function findOneById(UuidV4 $id): ?RaidTeam 
    {
        return $this->raidTeams[$id->toRfc4122()] ?? null;
    }

    public function findOneByRaidAndCharacter(Raid $raid, Character $character): ?CharacterSignup
    {
        foreach ($this->characterSignups as $characterSignup) {
            if (
                $characterSignup->getRaid()->getId() === $raid->getId() &&
                $characterSignup->getCharacter()->getId() === $character->getId()
            ) {
                return $characterSignup;
            }
        }

        return null;
    }

    public function findForRaid(Raid $raid): array
    {
        return array_filter($this->raidTeams, function ($raidTeam) use($raid) {
            return $raidTeam->getRaid() === $raid;
        });
    }
}