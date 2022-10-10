<?php

namespace App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid;

use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Raid\Raid;

class UnsignCharacterFromRaidCommand
{
    /**
     * @param Raid $raid
     * @param Character $character
     */
    public function __construct(
        private Raid $raid,
        private Character $character
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
}