<?php

namespace App\Domain\Entity\Raid\Repository;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\CharacterSignup;
use Symfony\Component\Uid\UuidV4;

interface ICharacterSignupRepository
{
    public function save(CharacterSignup $characterSignup): void;
    public function findOneById(UuidV4 $id): ?CharacterSignup;
    public function findOneByRaidAndCharacter(Raid $raid, Character $character): ?CharacterSignup;
    public function findForRaid(Raid $raid): array;
    public function findForCharacter(Character $character): array;
    public function findUpcommingForCharacter(Character $character): array;
}