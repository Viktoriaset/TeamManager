<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\AbstractRepositoryTest;
use App\Tests\MockUtils;

class UserRepositoryTest extends AbstractRepositoryTest
{
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getRepositoryForEntity(User::class);
    }

    public function testGetUsersByTeamId()
    {
        $team = MockUtils::createTeam();

        for ($i = 0; $i < 5; ++$i) {
            $user = MockUtils::createUser()->addTeam($team)
                ->setFirstName('trtrt'.$i);

            $this->em->persist($user);
        }

        $this->em->persist($team);
        $this->em->flush();

        $this->assertCount(5, $this->userRepository->getUsersByTeamId($team->getId()));
    }
}
