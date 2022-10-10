<?php

namespace App\Tests\Application\Raid;

use App\Application\UseCase\Command\Raid\CreateRaidTeamMember\CreateRaidTeamMemberCommand;
use App\Application\UseCase\Command\Raid\CreateRaidTeamMember\CreateRaidTeamMemberResponse;
use App\Application\UseCase\Command\Raid\CreateRaidTeamMember\CreateRaidTeamMemberUseCase;
use App\Domain\Entity\Character\Character;
use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\Raid\Raid;
use App\Domain\Entity\Raid\RaidTeam;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use App\Domain\ValueObject\RaidTeamMemberStatus;
use App\Infrastructure\Raid\Repository\InMemoryRaidTeamMemberRepository;
use DateInterval;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CreateRaidTeamMemberTest extends KernelTestCase
{
    private GuildUser $validGuildUser;

    protected function setUp(): void
    {
        $this->validGuildUser = new GuildUser(
            new Guild,
            new User
        );
    }

    public function testCreateRaidTeamMember()
    {
        $raidTeamMemberRepository = $this->getRaidTeamMemberRepository();

        $startDateTime = new DateTimeImmutable('tomorrow');
        $raid = $this->createRaid($startDateTime);
        $raidTeam = $this->createRaidTeam($raid);

        $user = $this->createUser();
        $character = $this->createCharacter($user);

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
        $createRaidTeamMemberResponse = $createRaidTeamMemberUseCase->execute();

        $this->assertInstanceOf(CreateRaidTeamMemberResponse::class, $createRaidTeamMemberResponse);
        $this->assertEquals($createRaidTeamMemberResponse->getRaidTeamMember(), $raidTeamMemberRepository->findOneById($createRaidTeamMemberResponse->getRaidTeamMember()->getId()));
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

    private function getRaidTeamMemberRepository(): InMemoryRaidTeamMemberRepository
    {
        return new InMemoryRaidTeamMemberRepository;
    }
}