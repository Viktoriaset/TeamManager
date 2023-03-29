<?php

namespace App\Service;

use App\Exception\GroupNotFoundException;
use App\Mapper\MemberMapper;
use App\Model\MemberListResponse;
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
            [MemberMapper::class, 'memberMap'],
            $members
        ));
    }
}
