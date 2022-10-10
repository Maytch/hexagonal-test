<?php 

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

class RaidPeriod
{
    public function __construct(
        private DateTimeImmutable $startDateTime,
        private ?DateTimeImmutable $endDateTime = null
    ) {
        $this->validate($startDateTime, $endDateTime);
    }

    public function getStartDateTime(): DateTimeImmutable
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): DateTimeImmutable
    {
        return $this->endDateTime;
    }

    private function validate(
        DateTimeImmutable $startDateTime,
        ?DateTimeImmutable $endDateTime = null
    )
    {
        if (
            $endDateTime !== null &&
            $startDateTime >= $endDateTime
        ) {
            throw new InvalidArgumentException('Start must be before End');
        }
    }
}