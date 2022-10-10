<?php

namespace App\Tests\Application\Raid;

use App\Application\UseCase\Command\Raid\CharacterSignup\CharacterSignupCommand;
use App\Application\UseCase\Command\Raid\CharacterSignup\CharacterSignupUseCase;
use App\Application\UseCase\Command\Raid\CreateRaidTeamMember\CreateRaidTeamMemberCommand;
use App\Application\UseCase\Command\Raid\CreateRaidTeamMember\CreateRaidTeamMemberUseCase;
use App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid\UnsignCharacterFromRaidCommand;
use App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid\UnsignCharacterFromRaidResponse;
use App\Application\UseCase\Command\Raid\UnsignCharacterFromRaid\UnsignCharacterFromRaidUseCase;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\CharacterSignupStatus;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use App\Domain\ValueObject\RaidTeamMemberStatus;
use App\Infrastructure\Raid\Repository\InMemoryCharacterSignupRepository;
use App\Infrastructure\Raid\Repository\InMemoryRaidTeamMemberRepository;
use DateInterval;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class UnsignCharacterFromRaidTest extends KernelTestCase
{
    private GuildUser $validGuildUser;

    protected function setUp(): void
    {
        $this->validGuildUser = new GuildUser(
            new Guild,
            new User
        );
    }

    public function testUnsignCharacterFromRaid()
    {
        $characterSignupRepository = $this->getCharacterSignupRepository();
        $raidTeamMemberRepository = $this->getRaidTeamMemberRepository();

        $startDateTime = new DateTimeImmutable('tomorrow');
        $raid = $this->createRaid($startDateTime);
        $raidTeam = $this->createRaidTeam($raid);

        $user = $this->createUser();
        $character = $this->createCharacter($user);
        $characterSignupStatus = CharacterSignupStatus::ACTIVE;

        $createCharacterSignupCommand = new CharacterSignupCommand(
            $raid,
            $character,
            $characterSignupStatus
        );

        $createCharacterSignupUseCase = new CharacterSignupUseCase(
            $characterSignupRepository,
            $createCharacterSignupCommand
        );
        $createCharacterSignupUseCase->execute();

        $raidTeamMemberStatus = RaidTeamMemberStatus::ACTIVE;

        $createRaidTeamMemberCommand = new CreateRaidTeamMemberCommand(
            $raidTeam,
            $character,
            $raidTeamMemberStatus
        );
        
        $createRaidTeamMemberUseCase = new CreateRaidTeamMemberUseCase(
            $raidTeamMemberRepository,
            $createRaidTeamMemberCommand,
            $this->validGuildUser
        );
        $createRaidTeamMemberUseCase->execute();

        $unsignCharacterFromRaidCommand = new UnsignCharacterFromRaidCommand(
            $raid,
            $character
        );

        $unsignCharacterFromRaidUseCase = new UnsignCharacterFromRaidUseCase(
            $characterSignupRepository,
            $raidTeamMemberRepository,
            $unsignCharacterFromRaidCommand,
            $this->validGuildUser
        );
        $unsignCharacterFromRaidResponse = $unsignCharacterFromRaidUseCase->execute();

        $this->assertInstanceOf(UnsignCharacterFromRaidResponse::class, $unsignCharacterFromRaidResponse);
        $this->assertEquals($unsignCharacterFromRaidResponse->getCharacterSignup(), $characterSignupRepository->findOneById($unsignCharacterFromRaidResponse->getCharacterSignup()->getId()));
        $this->assertEquals($unsignCharacterFromRaidResponse->getRaidTeamMember(), $raidTeamMemberRepository->findOneById($unsignCharacterFromRaidResponse->getRaidTeamMember()->getId()));

        $this->assertEquals(RaidTeamMemberStatus::UNSIGNED, $unsignCharacterFromRaidResponse->getRaidTeamMember()->getRaidTeamMemberStatus());
        $this->assertEquals(CharacterSignupStatus::UNSIGNED, $unsignCharacterFromRaidResponse->getCharacterSignup()->getCharacterSignupStatus());
    }

    private function createRaidTeam(Raid $raid)
    {
        $title = 'Test Raid Team';
        $description = '';

        return new RaidTeam(
            Uuid::v4(),
            $raid,
            $title,
            $description
        );
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

    private function getRaidTeamMemberRepository(): InMemoryRaidTeamMemberRepository
    {
        return new InMemoryRaidTeamMemberRepository;
    }
}