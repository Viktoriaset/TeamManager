<?php

namespace App\Model;

class GroupVisitedTableResponse
{
    /**
     * @param MemberEventsResponse[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return MemberEventsResponse[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


}
