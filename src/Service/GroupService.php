<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\Member;
use App\Exception\GroupNotFoundException;
use App\Exception\UserNotFoundException;
use App\Model\GroupListResponse;
use App\Model\GroupModel;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;
use App\Repository\UserRepository;

class GroupService
{
    public function __construct(
       private UserRepository $userRepository,
       private MemberRepository $memberRepository,
       private GroupRepository $groupRepository)
    {
    }

    public function getGroupsByUserId(int $userId): GroupListResponse
    {
        if (!$this->userRepository->existsById($userId)) {
            throw new UserNotFoundException();
        }

        $memberships = $this->memberRepository->findAllByUser($userId);

        return new GroupListResponse(array_map(
            fn (Member $member) => $this->map($member->getGroup()),
            $memberships
        ));
    }

    public function getGroupById(int $groupId): GroupModel
    {
        if (!$this->groupRepository->existsById($groupId)) {
            throw new GroupNotFoundException();
        }

        return $this->map($this->groupRepository->getGroupById($groupId));
    }

    private function map(Group $group): GroupModel
    {
        return (new GroupModel())->setId($group->getId())
            ->setTitle($group->getTitle())
            ->setDescription($group->getDescription());
    }
}
