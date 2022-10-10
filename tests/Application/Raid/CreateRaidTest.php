<?php

namespace App\Tests\Application\Raid;

use App\Application\UseCase\Command\Raid\Create\CreateRaidCommand;
use App\Application\UseCase\Command\Raid\Create\CreateRaidResponse;
use App\Application\UseCase\Command\Raid\Create\CreateRaidUseCase;
use App\Domain\Entity\Guild\Guild;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\GuildUser;
use App\Domain\ValueObject\RaidPeriod;
use App\Infrastructure\Raid\Repository\InMemoryRaidRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateRaidTest extends KernelTestCase
{
    private GuildUser $validGuildUser;

    protected function setUp(): void
    {
        $this->validGuildUser = new GuildUser(
            new Guild,
            new User
        );
    }

    public function testCreateRaid()
    {
        $raidRepository = $this->getRaidRepository();

        $title = 'Test Raid';
        $raidLocations = [];
        $description = '';

        $raidPeriod = new RaidPeriod(
            new DateTimeImmutable('2022-10-04 18:00:00'),
            new DateTimeImmutable('2022-10-04 21:00:00')
        );

        $raidPermissions = [];
        $raidRules = [];

        $createRaidCommand = new CreateRaidCommand(
            $title,
            $raidLocations,
            $description,
            $raidPeriod,
            $raidPermissions,
            $raidRules
        );
        
        $createRaidUseCase = new CreateRaidUseCase(
            $raidRepository,
            $createRaidCommand,
            $this->validGuildUser
        );
        $createRaidResponse = $createRaidUseCase->execute();

        $this->assertInstanceOf(CreateRaidResponse::class, $createRaidResponse);
        $this->assertEquals($createRaidResponse->getRaid(), $raidRepository->findOneById($createRaidResponse->getRaid()->getId()));
    }

    private function getRaidRepository(): InMemoryRaidRepository
    {
        return new InMemoryRaidRepository;
    }
}