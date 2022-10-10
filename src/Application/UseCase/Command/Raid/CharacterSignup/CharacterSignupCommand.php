<?php

namespace App\Application\UseCase\Command\Raid\CharacterSignup;

use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\Raid;
use App\Domain\ValueObject\CharacterSignupStatus;

class CharacterSignupCommand
{
    /**
     * @param Raid $raid
     * @param Character $character
     * @param CharacterSignupStatus $characterSignupStatus
     */
    public function __construct(
        private Raid $raid,
        private Character $character,
        private CharacterSignupStatus $characterSignupStatus
    )
    {
        
    }

    /**
     * @return Raid
     */
    public function getRaid(): Raid
    {
        return $this->raid;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @return CharacterSignupStatus
     */
    public function getCharacterSignupStatus(): CharacterSignupStatus
    {
        return $this->characterSignupStatus;
    }
}