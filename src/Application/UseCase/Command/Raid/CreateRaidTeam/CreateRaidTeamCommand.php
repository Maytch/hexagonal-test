<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeam;

use App\Domain\Entity\Raid\Raid;

class CreateRaidTeamCommand
{
    /**
     * @param Raid $raid
     * @param string $title
     * @param string $description
     */
    public function __construct(
        private Raid $raid,
        private string $title,
        private string $description,
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return CharacterSignup[]
     */
    public function getCharacterSignups(): array 
    {
        return $this->characterSignups;
    }
}