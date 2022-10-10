<?php

namespace App\Domain\Entity\Raid;

use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use DateTimeImmutable;
use Symfony\Component\Uid\UuidV4;

class Raid
{
    /**
     * @param UuidV4 $id
     * @param Guild $guild
     * @param User $user
     * @param string $title
     * @param RaidLocation[] $raidLocations
     * @param string $description
     * @param RaidPeriod[] $raidPeriods
     * @param RaidPermission[] $raidPermissions
     * @param RaidRules[] $raidRules
     */
    public function __construct(
        private UuidV4 $id,
        private Guild $guild,
        private User $user,
        private string $title,
        private array $raidLocations,
        private string $description,
        private RaidPeriod $raidPeriod,
        private array $raidPermissions,
        private array $raidRules,
        private DateTimeImmutable $createdAt,
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

    public function getGuild(): Guild 
    {
        return $this->guild;
    }

    public function getUser(): User 
    {
        return $this->user;
    }

    public function getGuildUser(): GuildUser
    {
        return new GuildUser(
            $this->guild,
            $this->user
        );
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

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param string $title
     * @return Raid
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $raidLocations
     * @return Raid
     */
    public function setRaidLocations(array $raidLocations): Raid
    {
        $this->raidLocations = $raidLocations;
        return $this;
    }

    /**
     * @param string $description
     * @return Raid
     */
    public function setDescription(string $description): Raid
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param RaidPeriod $raidPeriod
     * @return Raid
     */
    public function setRaidPeriod(RaidPeriod $raidPeriod): Raid 
    {
        $this->raidPeriod = $raidPeriod;
        return $this;
    }

    /**
     * @param RaidPermission[] $raidPermissions
     * @return Raid
     */
    public function setRaidPermissions(array $raidPermissions): Raid
    {
        $this->raidPermissions = $raidPermissions;
        return $this;
    }

    /**
     * @param RaidRule[] $raidRules
     * @return Raid
     */
    public function setRaidRules(array $raidRules): Raid 
    {
        $this->raidRules = $raidRules;
        return $this;
    }
}