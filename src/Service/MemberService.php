<?php

namespace App\Service;

use App\Entity\Member;
use App\Exception\GroupNotFoundException;
use App\Model\MemberListResponse;
use App\Model\MemberModel;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;

class MemberService
{
    public function __construct(
        private MemberRepository $memberRepository,
        private GroupRepository $groupRepository, )
    {
    }

    public function findAllByTeamId(int $groupId): MemberListResponse
    {
        if (!$this->groupRepository->existsById($groupId)) {
            throw new GroupNotFoundException();
        }

        $members = $this->memberRepository->findAllByGroup($groupId);

        return new MemberListResponse(array_map(
            [$this, 'map'],
            $members
        ));
    }

    private function map(Member $member): MemberModel
    {
        return (new MemberModel())->setUserId($member->getUserData()->getId())
            ->setFirstName($member->getUserData()->getFirstName())
            ->setSecondName($member->getUserData()->getSecondName())
            ->setPatronymic($member->getUserData()->getPatronymic());
    }
}
