<?php

namespace App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid;

use App\Domain\Entity\Raid\Repository\ICharacterSignupRepository;
use App\Domain\Entity\Raid\Repository\IRaidTeamMemberRepository;
use App\Domain\Exception\InvalidPermissionException;
use App\Domain\ValueObject\CharacterSignupStatus;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidTeamMemberStatus;

class UnsignCharacterFromRaidUseCase
{
    public function __construct(
        private ICharacterSignupRepository $characterSignupRepository,
        private IRaidTeamMemberRepository $raidTeamMemberRepository,
        private UnsignCharacterFromRaidCommand $command,
        private GuildUser $guildUser
    )
    {
    }

    public function execute()
    {
        $this->validate();

        $characterSignup = $this->characterSignupRepository->findOneByRaidAndCharacter($this->command->getRaid(), $this->command->getCharacter());
        $raidTeamMember = $this->raidTeamMemberRepository->findOneByRaidAndCharacter($this->command->getRaid(), $this->command->getCharacter());

        $characterSignup->setCharacterSignupStatus(CharacterSignupStatus::UNSIGNED);
        $this->characterSignupRepository->save($characterSignup);

        $raidTeamMember->setRaidTeamMemberStatus(RaidTeamMemberStatus::UNSIGNED);
        $this->raidTeamMemberRepository->save($raidTeamMember);

        return new UnsignCharacterFromRaidResponse(
            $characterSignup,
            $raidTeamMember
        );
    }

    private function validate()
    {
        if ($this->command->getRaid()->getUser() !== $this->guildUser->getUser() &&
            $this->command->getCharacter()->getUser() !== $this->guildUser->getUser()) {
            throw new InvalidPermissionException('Guild User does not have the permission to unsign Character from this Raid');
        }
    }
}