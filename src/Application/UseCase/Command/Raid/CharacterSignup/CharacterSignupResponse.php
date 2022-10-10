<?php

namespace App\Application\UseCase\Command\Raid\CharacterSignup;

use App\Domain\Entity\Raid\CharacterSignup;

class CharacterSignupResponse
{
    public function __construct(
        private CharacterSignup $characterSignup
    )
    {
    }

    public function getCharacterSignup(): CharacterSignup
    {
        return $this->characterSignup;
    }
}