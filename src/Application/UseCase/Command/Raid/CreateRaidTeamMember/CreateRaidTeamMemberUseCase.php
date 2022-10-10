<?php

namespace App\Application\UseCase\Command\Raid\CreateRaidTeamMember;

use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\Raid\RaidTeamMember;
use App\Domain\Entity\Raid\Repository\IRaidTeamMemberRepository;
use App\Domain\Exception\InvalidPermissionException;
use App\Domain\ValueObject\GuildUser;
use Symfony\Component\Uid\Uuid;

class CreateRaidTeamMemberUseCase
{
    public function __construct(
        private IRaidTeamMemberRepository $raidTeamMemberRepository,
        private CreateRaidTeamMemberCommand $command,
        private GuildUser $guildUser
    )
    {
    }

    public function execute()
    {
        $id = Uuid::v4();

        $raidTeamMember = new RaidTeamMember(
            $id,
            $this->command->getRaidTeam(),
            $this->command->getCharcter(),
            $this->command->getRaidTeamMemberStatus()
        );

        $this->validate($raidTeamMember);

        $this->raidTeamMemberRepository->save($raidTeamMember);

        return new CreateRaidTeamMemberResponse($raidTeamMember);
    }

    private function validate()
    {
        if ($this->command->getRaidTeam()->getRaid()->getUser() !== $this->guildUser->getUser()) {
            throw new InvalidPermissionException('Guild User does not have the permission to create Raid Team Members for this Raid');
        }
    }
}