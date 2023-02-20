<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Exception\TeamNotFoundException;
use App\Model\UserListResponse;
use App\Model\UserModel;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Tests\AbstractTestCase;

class UserServiceTest extends AbstractTestCase
{
    private UserRepository $userRepository;

    private TeamRepository $teamRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->teamRepository = $this->createMock(TeamRepository::class);
    }

    public function testGetUsersByTeamIdWhenTeamNotFound()
    {
        $this->expectException(TeamNotFoundException::class);

        $this->teamRepository->expects($this->once())
            ->method('existsById')
            ->with(2)
            ->willReturn(false);

        $this->createService()->getUsersByTeamId(2);
    }

    public function testGetUsersByTeamId()
    {
        $this->teamRepository->expects($this->once())
            ->method('existsById')
            ->with(2)
            ->willReturn(true);

        $user = (new User())
            ->setPatronymic('Tester')
            ->setSecondName('Tester')
            ->setFirstName('Tester');

        $this->setEntityId($user, 1);

        $this->userRepository->expects($this->once())
            ->method('getUsersByTeamId')
            ->with(2)
            ->willReturn([$user]);

        $expectedUserResponse = new UserListResponse([
            (new UserModel())->setId(1)->setFirstName('Tester')
            ->setSecondName('Tester')->setPatronymic('Tester'),
        ]);

        $this->assertEquals($expectedUserResponse, $this->createService()->getUsersByTeamId(2));
    }

    private function createService(): UserService
    {
        return new UserService($this->userRepository, $this->teamRepository);
    }
}
