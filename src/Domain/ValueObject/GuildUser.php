<?php 

namespace App\Domain\ValueObject;

use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\User\User;

class GuildUser
{
    public function __construct(
        private Guild $guild,
        private User $user
    )
    {
    }

    public function getGuild(): Guild 
    {
        return $this->guild;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function hasPermissionToCreateRaid(): bool
    {
        return true;
    }
}