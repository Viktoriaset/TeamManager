<?php

namespace App\Tests;

use App\Entity\Event;
use App\Entity\Group;
use App\Entity\Member;
use App\Entity\User;

class MockUtils
{
    public static function createUser(): User
    {
        return (new User())->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov')
            ->setEmail('test@mail.com')
            ->setPassword('testPassword');
    }

    public static function createGroup(): Group
    {
        return (new Group())->setTitle('test Group')
            ->setDescription('test Description');
    }

    public static function createMember(User $user, Group $group): Member
    {
        return (new Member())->setUserData($user)->setGroup($group);
    }

    public static function createEvent(Member $member): Event
    {
        return (new Event())->setMember($member)
            ->setDescription('test Description')
            ->setTrainingDate(new \DateTime('2022-10-10'))
            ->setVisited(true);
    }
}
