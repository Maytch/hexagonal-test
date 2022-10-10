<?php

namespace App\Domain\Entity\Character;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\User\User;
use Symfony\Component\Uid\UuidV4;

class Character 
{
    public function __construct(
        private UuidV4 $id,
        private User $user
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

    public function getUser(): User 
    {
        return $this->user;
    }

    public function hasPermissionToSignupToRaid(Raid $raid)
    {
        return true;
    }

    public function meetsRaidRuleCriteriaToSignupToRaid(Raid $raid)
    {
        return true;
    }
}