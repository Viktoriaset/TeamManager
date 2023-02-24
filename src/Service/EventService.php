<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Member;
use App\Exception\GroupNotFoundException;
use App\Mapper\MemberMapper;
use App\Model\EventModel;
use App\Model\GroupVisitedTableResponse;
use App\Model\MemberEventsResponse;
use App\Repository\EventRepository;
use App\Repository\GroupRepository;
use App\Repository\MemberRepository;

class EventService
{
    public function __construct(
        private EventRepository $eventRepository,
        private MemberRepository $memberRepository,
        private GroupRepository $groupRepository)
    {
    }

    public function getGroupEvents(int $groupId): MemberEventsResponse
    {
        if (!$this->groupRepository->existsById($groupId)) {
            throw new GroupNotFoundException();
        }

        $groupLeader = $this->memberRepository->findGroupLeader($groupId);

        return $this->getMemberEventsResponseByMember($groupLeader);
    }

    public function getGroupVisitedTable(int $groupId): GroupVisitedTableResponse
    {
        if (!$this->groupRepository->existsById($groupId)) {
            throw new GroupNotFoundException();
        }

        $groupMembers = $this->memberRepository->findAllByGroup($groupId);

        return new GroupVisitedTableResponse(array_map(
            [$this, 'getMemberEventsResponseByMember'],
            $groupMembers
        ));
    }

    private function getMemberEventsResponseByMember(Member $member): MemberEventsResponse
    {
        $groupEvents = $this->eventRepository->getEventsByMember($member->getId());

        return new MemberEventsResponse(MemberMapper::memberMap($member), array_map(
            [$this, 'map'],
            $groupEvents
        ));
    }

    private function map(Event $event): EventModel
    {
        return (new EventModel())->setId($event->getId())
            ->setDatetime($event->getTrainingDate()->getTimestamp())
            ->setVisited($event->isVisited())->setDescription($event->getDescription());
    }
}
