<?php

namespace App\Application\UseCase\Command\Raid\Create;

use App\Domain\ValueObject\RaidPeriod;

class CreateRaidCommand
{
    /**
     * @param string $title
     * @param RaidLocation[] $raidLocations
     * @param string $description
     * @param RaidPeriod[] $raidPeriods
     * @param RaidPermission[] $raidPermissions
     * @param RaidRules[] $raidRules
     */
    public function __construct(
        private string $title,
        private array $raidLocations,
        private string $description,
        private RaidPeriod $raidPeriod,
        private array $raidPermissions,
        private array $raidRules
    )
    {
        
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return RaidLocation[]
     */
    public function getRaidLocations(): array
    {
        return $this->raidLocations;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return RaidPeriod
     */
    public function getRaidPeriod(): RaidPeriod 
    {
        return $this->raidPeriod;
    }

    /**
     * @return RaidPermission[]
     */
    public function getRaidPermissions(): array
    {
        return $this->raidPermissions;
    }

    /**
     * @return RaidRule[]
     */
    public function getRaidRules(): array 
    {
        return $this->raidRules;
    }
}