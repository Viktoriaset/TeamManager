<?php

namespace App\Tests\Service;

use App\Tests\MockUtils;

trait MemberCreator
{
    abstract protected function setEntityId(object $entity, int $value, $idField = 'id');

    public function createMember()
    {
        $group = MockUtils::createGroup();
        $user = MockUtils::createUser();
        $member = MockUtils::createMember($user, $group);

        $this->setEntityId($group, 1);
        $this->setEntityId($user, 1);
        $this->setEntityId($member, 1);

        return $member;
    }
}
