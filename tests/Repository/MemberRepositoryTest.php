<?php

namespace App\Tests\Repository;

use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Tests\AbstractRepositoryTest;
use App\Tests\MockUtils;

class MemberRepositoryTest extends AbstractRepositoryTest
{
    private MemberRepository $memberRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->memberRepository = $this->getRepositoryForEntity(Member::class);
    }

    public function testFindAllByGroup()
    {
        $group = MockUtils::createGroup();

        $this->em->persist($group);

        for ($i = 0; $i < 5; ++$i) {
            $user = MockUtils::createUser()->setFirstName('tester '.$i);

            $this->em->persist($user);
            $this->em->persist(MockUtils::createMember($user, $group));
        }

        $this->em->flush();

        $this->assertCount(5, $this->memberRepository->findAllByGroup($group->getId()));
    }

    public function testFindAllByUser()
    {
        $user = MockUtils::createUser();

        for ($i = 0; $i < 5; ++$i) {
            $group = MockUtils::createGroup()->setTitle('test '.$i);

            $this->em->persist($group);
            $this->em->persist(MockUtils::createMember($user, $group));
        }

        $this->em->flush();

        $this->assertCount(5, $this->memberRepository->findAllByUser($user->getId()));
    }
}
