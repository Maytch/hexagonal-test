<?php 

namespace App\Domain\Entity\Raid;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Character\Character;
use App\Domain\ValueObject\CharacterSignupStatus;
use Symfony\Component\Uid\UuidV4;

class CharacterSignup
{
    /**
     * @param UuidV4 $id
     * @param Raid $raid
     * @param Character $character
     * @param CharacterSignupStatus $characterSignupStatus
     */
    public function __construct(
        private UuidV4 $id,
        private Raid $raid,
        private Character $character,
        private CharacterSignupStatus $characterSignupStatus
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
     * @return Character
     */
    public function getCharacterSignupStatus(): CharacterSignupStatus
    {
        return $this->characterSignupStatus;
    }

    /**
     * @param CharacterSignupStatus $characterSignupStatus
     * @return CharacterSignup
     */
    public function setCharacterSignupStatus(CharacterSignupStatus $characterSignupStatus): CharacterSignup
    {
        $this->characterSignupStatus = $characterSignupStatus;
        return $this;
    }
}