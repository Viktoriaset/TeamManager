<?php

namespace App\Service;

use App\Entity\Member;
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
       private MemberRepository $memberRepository, )
    {
    }

    public function getGroupsByUserId(int $userId): GroupListResponse
    {
        if (!$this->userRepository->existsById($userId)) {
            throw new UserNotFoundException();
        }

        $memberships = $this->memberRepository->findAllByUser($userId);

        return new GroupListResponse(array_map(
            [$this, 'map'],
            $memberships
        ));
    }

    private function map(Member $member): GroupModel
    {
        return (new GroupModel())->setId($member->getGroup()->getId())
            ->setTitle($member->getGroup()->getTitle())
            ->setDescription($member->getGroup()->getDescription());
    }
}
