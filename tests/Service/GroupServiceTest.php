<?php

namespace App\Tests\Service;

use App\Exception\GroupNotFoundException;
use App\Exception\UserNotFoundException;
use App\Model\GroupListResponse;
use App\Model\GroupModel;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;
use App\Repository\UserRepository;
use App\Service\GroupService;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class GroupServiceTest extends AbstractTestCase
{
    private MemberRepository $memberRepository;

    private UserRepository $userRepository;

    private GroupRepository $groupRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->memberRepository = $this->createMock(MemberRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->groupRepository = $this->createMock(GroupRepository::class);
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
            ->setTitle('test Group')->setDescription('test Description'),
        ]);

        $this->assertEquals($expectedGroupListResponse, $this->createTeamService()->getGroupsByUserId(1));
    }

    public function testGetGroupByIdWhenGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);

        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(false);

        $this->createTeamService()->getGroupById(1);
    }

    public function testGetGroupById()
    {
        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $group = MockUtils::createGroup();
        $this->setEntityId($group, 1);

        $this->groupRepository->expects($this->once())
            ->method('getGroupById')
            ->with(1)
            ->willReturn($group);

        $expectedGroupModel = (new GroupModel())->setTitle('test Group')
            ->setDescription('test Description')->setId(1);

        $this->assertEquals($expectedGroupModel, $this->createTeamService()->getGroupById(1));
    }

    private function createTeamService(): GroupService
    {
        return new GroupService($this->userRepository, $this->memberRepository, $this->groupRepository);
    }
}
