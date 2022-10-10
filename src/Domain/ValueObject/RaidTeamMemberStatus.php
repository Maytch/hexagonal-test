<?php

namespace App\Domain\ValueObject;

enum RaidTeamMemberStatus 
{
    case ACTIVE;
    case BENCHED;
    case ABSENT;
    case UNSIGNED;
}