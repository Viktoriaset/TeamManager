<?php

namespace App\Tests\Service;

use App\Exception\UserNotFoundException;
use App\Model\GroupListResponse;
use App\Model\GroupModel;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;
use App\Repository\UserRepository;
use App\Service\GroupService;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class TeamServiceTest extends AbstractTestCase
{
    private MemberRepository $memberRepository;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->memberRepository = $this->createMock(MemberRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testGetGroupsByUserIdWhenUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);

        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(false);

        $this->createTeamService()->getGroupsByUserId(1);
    }

    public function testGetGroupsByUserId()
    {
        $this->userRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $group = MockUtils::createGroup();
        $user = MockUtils::createUser();
        $member = MockUtils::createMember($user, $group);

        $this->setEntityId($group, 1);
        $this->setEntityId($user, 1);
        $this->setEntityId($member, 1);

        $this->memberRepository->expects($this->once())
            ->method('findAllByUser')
            ->with(1)
            ->willReturn([$member]);

        $expectedGroupListResponse = new GroupListResponse([(new GroupModel())->setId(1)
            ->setTitle('test Team')->setDescription('test Description'),
        ]);

        $this->assertEquals($expectedGroupListResponse, $this->createTeamService()->getGroupsByUserId(1));
    }

    private function createTeamService(): GroupService
    {
        return new GroupService($this->userRepository, $this->memberRepository);
    }
}
