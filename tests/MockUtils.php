<?php

namespace App\Tests;

use App\Entity\Group;
use App\Entity\User;

class MockUtils
{
    public static function createUser(): User
    {
        return (new User())->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov');
    }

    public static function createTeam(): Group
    {
        return (new Group())->setTitle('test Team')
            ->setDescription('test Description');
    }
}
