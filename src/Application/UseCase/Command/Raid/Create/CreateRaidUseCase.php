<?php

namespace App\Application\UseCase\Command\Raid\Create;

use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\Repository\IRaidRepository;
use App\Domain\Exception\InvalidPermissionException;
use App\Domain\ValueObject\GuildUser;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class CreateRaidUseCase
{
    public function __construct(
        private IRaidRepository $raidRepository,
        private CreateRaidCommand $command,
        private GuildUser $guildUser
    )
    {
    }

    public function execute()
    {
        $id = Uuid::v4();

        $raid = new Raid(
            $id,
            $this->guildUser->getGuild(),
            $this->guildUser->getUser(),
            $this->command->getTitle(),
            $this->command->getRaidLocations(),
            $this->command->getDescription(),
            $this->command->getRaidPeriod(),
            $this->command->getRaidPermissions(),
            $this->command->getRaidRules(),
            new DateTimeImmutable()
        );

        $this->validate($raid, $this->guildUser);

        $this->raidRepository->save($raid);

        return new CreateRaidResponse($raid);
    }

    private function validate(Raid $raid, GuildUser $guildUser)
    {
        if (!$guildUser->hasPermissionToCreateRaid()) {
            throw new InvalidPermissionException('Guild User does not have the permission to create Raids');
        }
    }
}