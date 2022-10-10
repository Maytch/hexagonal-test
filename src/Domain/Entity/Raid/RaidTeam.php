<?php 

namespace App\Domain\Entity\Raid;

use App\Domain\Entity\Raid\Raid;
use Symfony\Component\Uid\UuidV4;

class RaidTeam
{
    /**
     * @param UuidV4 $id
     * @param Raid $raid
     * @param string $title
     * @param string $description
     */
    public function __construct(
        private UuidV4 $id,
        private Raid $raid,
        private string $title,
        private string $description,
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
}