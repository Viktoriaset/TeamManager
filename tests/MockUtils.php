<?php

namespace App\Tests;

use App\Entity\Group;
use App\Entity\Member;
use App\Entity\User;

class MockUtils
{
    public static function createUser(): User
    {
        return (new User())->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov');
    }

    public static function createGroup(): Group
    {
        return (new Group())->setTitle('test Team')
            ->setDescription('test Description');
    }

    public static function createMember(User $user, Group $group): Member
    {
        return (new Member())->setGroup($group)->setUserData($user);
    }
}
