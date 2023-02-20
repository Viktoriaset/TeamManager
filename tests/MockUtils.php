<?php

namespace App\Tests;

use App\Entity\Team;
use App\Entity\User;

class MockUtils
{
    public static function createUser(): User
    {
        return (new User())->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov');
    }

    public static function createTeam(): Team
    {
        return (new Team())->setTitle('test Team')
            ->setDescription('test Description');
    }
}
