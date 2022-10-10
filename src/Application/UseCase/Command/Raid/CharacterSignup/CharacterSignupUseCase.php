<?php

namespace App\Application\UseCase\Command\Raid\CharacterSignup;

use App\Domain\Entity\Raid\CharacterSignup;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\Repository\ICharacterSignupRepository;
use App\Domain\Entity\Character\Character;
use App\Domain\Exception\InvalidPermissionException;
use App\Domain\ValueObject\GuildUser;
use Symfony\Component\Uid\Uuid;

class CharacterSignupUseCase
{
    public function __construct(
        private ICharacterSignupRepository $characterSignupRepository,
        private CharacterSignupCommand $command
    )
    {
    }

    public function execute()
    {
        $id = Uuid::v4();

        $characterSignup = new CharacterSignup(
            $id,
            $this->command->getRaid(),
            $this->command->getCharacter(),
            $this->command->getCharacterSignupStatus()
        );

        $this->validate($characterSignup);

        $this->characterSignupRepository->save($characterSignup);

        return new CharacterSignupResponse($characterSignup);
    }

    private function validate(CharacterSignup $characterSignup)
    {
        if (!$characterSignup->getCharacter()->hasPermissionToSignupToRaid($characterSignup->getRaid())) {
            throw new InvalidPermissionException('Character does not have permission to sign up to Raid');
        }
        
        if (!$characterSignup->getCharacter()->hasPermissionToSignupToRaid($characterSignup->getRaid())) {
            throw new InvalidPermissionException('Character does not have permission to sign up to Raid');
        }
    }
}