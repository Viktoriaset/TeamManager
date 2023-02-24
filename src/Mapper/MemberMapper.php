<?php

namespace App\Mapper;

use App\Entity\Member;
use App\Model\MemberModel;

class MemberMapper
{
    public static function memberMap(Member $member): MemberModel
    {
        return (new MemberModel())->setUserId($member->getUserData()->getId())
            ->setFirstName($member->getUserData()->getFirstName())
            ->setSecondName($member->getUserData()->getSecondName())
            ->setPatronymic($member->getUserData()->getPatronymic());
    }
}
