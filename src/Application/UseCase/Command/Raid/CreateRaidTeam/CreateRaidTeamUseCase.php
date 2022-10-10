<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeam;

use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\Repository\IRaidTeamRepository;
use App\Domain\Exception\InvalidPermissionException;
use App\Domain\ValueObject\GuildUser;
use Symfony\Component\Uid\Uuid;

class CreateRaidTeamUseCase
{
    public function __construct(
        private IRaidTeamRepository $raidTeamRepository,
        private CreateRaidTeamCommand $command,
        private GuildUser $guildUser
    )
    {
    }

    public function execute()
    {
        $id = Uuid::v4();

        $raidTeam = new RaidTeam(
            $id,
            $this->command->getRaid(),
            $this->command->getTitle(),
            $this->command->getDescription()
        );

        $this->validate($raidTeam);

        $this->raidTeamRepository->save($raidTeam);

        return new CreateRaidTeamResponse($raidTeam);
    }

    private function validate(RaidTeam $raidTeam)
    {
        if ($raidTeam->getRaid()->getUser() !== $this->guildUser->getUser()) {
            throw new InvalidPermissionException('Guild User does not have the permission to create Raid Teams for this Raid');
        }
    }
}