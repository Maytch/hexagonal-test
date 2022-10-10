<?php 

namespace App\Infrastructure\Raid\Repository;

use App\Domain\Entity\Raid\CharacterSignup;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\Repository\ICharacterSignupRepository;
use App\Domain\Entity\Character\Character;
use DateTimeImmutable;
use Symfony\Component\Uid\UuidV4;

class InMemoryCharacterSignupRepository implements ICharacterSignupRepository
{
    protected array $characterSignups = [];

    public function save(CharacterSignup $characterSignup): void
    {
        $this->characterSignups[$characterSignup->getId()->toRfc4122()] = $characterSignup;
    }

    public function findOneById(UuidV4 $id): ?CharacterSignup 
    {
        return $this->characterSignups[$id->toRfc4122()] ?? null;
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
        return array_filter($this->characterSignups, function ($characterSignup) use($raid) {
            return $characterSignup->getRaid() === $raid;
        });
    }

    public function findForCharacter(Character $character): array
    {
        return array_filter($this->characterSignups, function ($characterSignup) use($character) {
            return $characterSignup->getRaid() === $character;
        });
    }
    
    public function findUpcommingForCharacter(Character $character): array
    {
        $now = new DateTimeImmutable();
        return array_filter($this->characterSignups, function ($characterSignup) use($character, $now) {
            return $characterSignup->getRaid() === $character &&
                $characterSignup->getRaid()->getEndDateTime() > $now;
        });
    }
}