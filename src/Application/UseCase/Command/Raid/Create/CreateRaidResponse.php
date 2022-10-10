<?php

namespace App\Application\UseCase\Command\Raid\Create;

use App\Domain\Entity\Raid\Raid;

class CreateRaidResponse
{
    public function __construct(
        private Raid $raid
    )
    {
    }

    public function getRaid(): Raid
    {
        return $this->raid;
    }
}