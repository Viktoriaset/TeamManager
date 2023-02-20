<?php

namespace App\Tests\Repository;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Tests\AbstractRepositoryTest;
use App\Tests\MockUtils;
use PHPUnit\Framework\TestCase;

class TeamRepositoryTest extends AbstractRepositoryTest
{

    private TeamRepository $teamRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamRepository = $this->getRepositoryForEntity(Team::class);
    }

    public function testFindTeamsByUserId()
    {
        $user = MockUtils::createUser();

        for ($i = 0; $i < 5; ++$i) {
            $team = MockUtils::createTeam()->addMember($user)
                ->setTitle('test title'.$i);

            $this->em->persist($team);
        }

        $this->em->persist($user);
        $this->em->flush();

        $this->assertCount(5, $this->teamRepository->findTeamsByUserId($user->getId()));
    }
}