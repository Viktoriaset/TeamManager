<?php

namespace App\Model;

use App\Entity\Member;

class MemberEventsResponse
{
    /**
     * @param EventModel[] $items
     */
    public function __construct(private MemberModel $member, private array $items)
    {
    }

    /**
     * @return EventModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getMember(): MemberModel
    {
        return $this->member;
    }


}
