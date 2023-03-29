<?php

namespace App\Tests\Service;

use App\Exception\GroupNotFoundException;
use App\Model\EventModel;
use App\Model\GroupVisitedTableResponse;
use App\Model\MemberEventsResponse;
use App\Model\MemberModel;
use App\Repository\EventRepository;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;
use App\Service\EventService;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class EventServiceTest extends AbstractTestCase
{
    use MemberCreator;

    private EventRepository $eventRepository;

    private MemberRepository $memberRepository;

    private GroupRepository $groupRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepository = $this->createMock(EventRepository::class);
        $this->memberRepository = $this->createMock(MemberRepository::class);
        $this->groupRepository = $this->createMock(GroupRepository::class);
    }

    public function testGetGroupEventsWhenGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);

        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(false);

        $this->createService()->getGroupEvents(1);
    }

    public function testGetGroupEvents()
    {
        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $groupLeader = $this->createMember();

        $this->memberRepository->expects($this->once())
            ->method('findGroupLeader')
            ->with(1)
            ->willReturn($groupLeader);

        $event = MockUtils::createEvent($groupLeader);

        $this->setEntityId($event, 1);

        $this->eventRepository->expects($this->once())
            ->method('getEventsByMember')
            ->with(1)
            ->willReturn([$event]);

        $expectedMemberEventsResponse = new MemberEventsResponse((new MemberModel())
            ->setUserId(1)
            ->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov'),
            [(new EventModel())->setId(1)
                ->setDescription('test Description')
                ->setVisited(true)
                ->setDatetime((new \DateTime('2022-10-10'))->getTimestamp()),
            ]);

        $this->assertEquals($expectedMemberEventsResponse, $this->createService()->getGroupEvents(1));
    }

    public function testGetMemberEventsResponseByMember()
    {
        $member = $this->createMember();

        $event = MockUtils::createEvent($member);
        $this->setEntityId($event, 1);

        $this->eventRepository->expects($this->once())
            ->method('getEventsByMember')
            ->with(1)
            ->willReturn([$event]);

        $expectedMemberEventsResponse = new MemberEventsResponse((new MemberModel())
            ->setUserId(1)
            ->setFirstName('Tester')
            ->setSecondName('tester')
            ->setPatronymic('testerov'),
            [(new EventModel())->setId(1)
                ->setDescription('test Description')
                ->setVisited(true)
                ->setDatetime((new \DateTime('2022-10-10'))->getTimestamp()),
            ]);

        $reflectionEventService = new \ReflectionClass(EventService::class);
        $method = $reflectionEventService->getMethod('getMemberEventsResponseByMember');
        $method->setAccessible(true);

        $this->assertEquals($expectedMemberEventsResponse, $method->invoke($this->createService(), $member));
    }

    public function testGetGroupVisitedTableWhenGroupNotFound()
    {
        $this->expectException(GroupNotFoundException::class);

        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(false);

        $this->createService()->getGroupEvents(1);
    }

    public function testGetGroupVisitedTable()
    {
        $this->groupRepository->expects($this->once())
            ->method('existsById')
            ->with(1)
            ->willReturn(true);

        $member = $this->createMember();

        $this->memberRepository->expects($this->once())
            ->method('findAllByGroup')
            ->with(1)
            ->willReturn([$member]);

        $event = MockUtils::createEvent($member);
        $this->setEntityId($event, 1);

        $this->eventRepository->expects($this->once())
            ->method('getEventsByMember')
            ->with(1)
            ->willReturn([$event]);

        $expectedGroupVisitedTableResponse = new GroupVisitedTableResponse([new MemberEventsResponse(
            (new MemberModel())
                ->setUserId(1)
                ->setFirstName('Tester')
                ->setSecondName('tester')
                ->setPatronymic('testerov'),
            [(new EventModel())->setId(1)
                ->setDescription('test Description')
                ->setVisited(true)
                ->setDatetime((new \DateTime('2022-10-10'))->getTimestamp()),
            ]),
        ]);

        $this->assertEquals($expectedGroupVisitedTableResponse, $this->createService()->getGroupVisitedTable(1));
    }

    private function createService()
    {
        return new EventService($this->eventRepository, $this->memberRepository, $this->groupRepository);
    }
}
