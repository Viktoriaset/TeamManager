<?php

namespace App\Tests\Service;

use App\Exception\UserNotFoundException;
use App\Model\TeamListResponse;
use App\Model\TeamModel;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use App\Service\GroupService;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class TeamServiceTest extends AbstractTestCase
{
    private GroupRepository $teamRepository;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamRepository = $this->createMock(GroupRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testGetTeamsByUserIdWhenUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);

        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(false);

        $this->createTeamService()->getTeamsByUserId(1);
    }

    public function testGetTeamsByUserId()
    {
        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $team = MockUtils::createTeam();

        $this->setEntityId($team, 1);

        $this->teamRepository->expects($this->once())
            ->method('findTeamsByUserId')
            ->with(1)
            ->willReturn([$team]);

        $expectTeamListResponse = new TeamListResponse([(new TeamModel())->setId(1)
            ->setTitle('test Team')->setDescription('test Description'),
        ]);

        $this->assertEquals($expectTeamListResponse, $this->createTeamService()->getTeamsByUserId(1));
    }

    private function createTeamService(): GroupService
    {
        return new GroupService($this->teamRepository, $this->userRepository);
    }
}
