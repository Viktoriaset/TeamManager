<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Model\UserModel;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Tests\AbstractTestCase;

class UserServiceTest extends AbstractTestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testGetUserByIdWhenUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);

        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(2)
            ->willReturn(false);

        $this->createService()->getUserById(2);
    }

    public function testGetUsersByTeamId()
    {
        $user = (new User())
            ->setPatronymic('Tester')
            ->setSecondName('Tester')
            ->setFirstName('Tester');

        $this->setEntityId($user, 1);

        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $this->userRepository->expects($this->once())
            ->method('getUserById')
            ->with(1)
            ->willReturn($user);

        $expectedUserResponse = (new UserModel())->setId(1)->setFirstName('Tester')
            ->setSecondName('Tester')->setPatronymic('Tester');

        $this->assertEquals($expectedUserResponse, $this->createService()->getUserById(1));
    }

    private function createService(): UserService
    {
        return new UserService($this->userRepository);
    }
}
