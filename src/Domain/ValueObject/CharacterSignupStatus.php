<?php

namespace App\Domain\ValueObject;

enum CharacterSignupStatus 
{
    case ACTIVE;
    case TENTATIVE;
    case BENCHED;
    case ABSENT;
    case UNSIGNED;
}