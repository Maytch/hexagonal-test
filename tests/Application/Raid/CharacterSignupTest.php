<?php

namespace App\Tests\Application\Raid;

use App\Application\UseCase\Command\Raid\CharacterSignup\CharacterSignupCommand;
use App\Application\UseCase\Command\Raid\CharacterSignup\CharacterSignupResponse;
use App\Application\UseCase\Command\Raid\CharacterSignup\CharacterSignupUseCase;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\CharacterSignupStatus;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use App\Infrastructure\Raid\Repository\InMemoryCharacterSignupRepository;
use DateInterval;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CharacterSignupTest extends KernelTestCase
{
    private GuildUser $validGuildUser;

    protected function setUp(): void
    {
        $this->validGuildUser = new GuildUser(
            new Guild,
            new User
        );
    }

    public function testCharacterSignup()
    {
        $startDateTime = new DateTimeImmutable('tomorrow');
        $raid = $this->createRaid($startDateTime);
        $user = $this->createUser();
        $character = $this->createCharacter($user);
        $characterSignupStatus = CharacterSignupStatus::ACTIVE;

        $characterSignupRepository = $this->getCharacterSignupRepository();

        $characterSignupCommand = new CharacterSignupCommand(
            $raid,
            $character,
            $characterSignupStatus
        );

        $characterSignupUseCase = new CharacterSignupUseCase(
            $characterSignupRepository,
            $characterSignupCommand
        );

        $characterSignupResponse = $characterSignupUseCase->execute();
        
        $this->assertInstanceOf(CharacterSignupResponse::class, $characterSignupResponse);
        $this->assertEquals($characterSignupResponse->getCharacterSignup(), $characterSignupRepository->findOneById($characterSignupResponse->getCharacterSignup()->getId()));
    }

    private function createRaid(DateTimeImmutable $startDateTime): Raid
    {
        $title = 'Test Raid';
        $raidLocations = [];
        $description = '';

        $endDateTime = $startDateTime->add(new DateInterval('PT3H'));

        $raidPeriod = new RaidPeriod(
            $startDateTime,
            $endDateTime
        );

        $raidPermissions = [];
        $raidRules = [];

        return new Raid(
            Uuid::v4(),
            $this->validGuildUser->getGuild(),
            $this->validGuildUser->getUser(),
            $title,
            $raidLocations,
            $description,
            $raidPeriod,
            $raidPermissions,
            $raidRules,
            new DateTimeImmutable()
        );
    }

    private function createUser(): User
    {
        return new User();
    }

    private function createCharacter(User $user): Character
    {
        return new Character(Uuid::v4(), $user);
    }

    private function getCharacterSignupRepository(): InMemoryCharacterSignupRepository
    {
        return new InMemoryCharacterSignupRepository;
    }
}