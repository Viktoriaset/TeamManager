<?php

namespace App\Tests\Repository;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Tests\AbstractRepositoryTest;
use App\Tests\MockUtils;
use Doctrine\Common\Collections\ArrayCollection;

class EventRepositoryTest extends AbstractRepositoryTest
{
    private EventRepository $eventRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepository = $this->getRepositoryForEntity(Event::class);
    }

    public function testGetEventsByMember()
    {
        $group = MockUtils::createGroup();
        $user = MockUtils::createUser();
        $member = MockUtils::createMember($user, $group);

        $this->em->persist($group);
        $this->em->persist($user);
        $this->em->persist($member);

        $events = new ArrayCollection();

        for ($i = 0; $i < 5; ++$i) {
            $event = MockUtils::createEvent($member)->setTrainingDate(new \DateTime('2019-11-0'.$i));

            $events->add($event);
            $this->em->persist($event);
        }

        $this->em->flush();

        $this->assertCount(5, $this->eventRepository->getEventsByMember($member->getId()));

        foreach ($events as $event) {
            $this->eventRepository->remove($event, true);
        }
    }
}
