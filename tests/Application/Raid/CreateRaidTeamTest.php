<?php

namespace App\Tests\Application\Raid;

use App\Application\UseCase\Command\Raid\CreateRaidTeam\CreateRaidTeamCommand;
use App\Application\UseCase\Command\Raid\CreateRaidTeam\CreateRaidTeamResponse;
use App\Application\UseCase\Command\Raid\CreateRaidTeam\CreateRaidTeamUseCase;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\Raid\CharacterSignup;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use App\Infrastructure\Raid\Repository\InMemoryRaidTeamRepository;
use DateInterval;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CreateRaidTeamTest extends KernelTestCase
{
    private GuildUser $validGuildUser;

    protected function setUp(): void
    {
        $this->validGuildUser = new GuildUser(
            new Guild,
            new User
        );
    }

    public function testCreateRaidTeam()
    {
        $raidTeamRepository = $this->getRaidTeamRepository();

        $startDateTime = new DateTimeImmutable('tomorrow');
        $raid = $this->createRaid($startDateTime);
        $title = 'Test Raid Team';
        $description = '';

        $createRaidTeamCommand = new CreateRaidTeamCommand(
            $raid,
            $title,
            $description
        );
        
        $createRaidTeamUseCase = new CreateRaidTeamUseCase(
            $raidTeamRepository,
            $createRaidTeamCommand,
            $this->validGuildUser
        );
        $createRaidTeamResponse = $createRaidTeamUseCase->execute();

        $this->assertInstanceOf(CreateRaidTeamResponse::class, $createRaidTeamResponse);
        $this->assertEquals($createRaidTeamResponse->getRaidTeam(), $raidTeamRepository->findOneById($createRaidTeamResponse->getRaidTeam()->getId()));
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

    private function createCharacterSignup(Raid $raid, Character $character): CharacterSignup
    {
        return new CharacterSignup(
            Uuid::v4(),
            $raid,
            $character
        );
    }

    private function getRaidTeamRepository(): InMemoryRaidTeamRepository
    {
        return new InMemoryRaidTeamRepository;
    }
}