<?php

namespace App\Model;

class GroupListResponse
{
    /**
     * @param GroupModel[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return GroupModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


}
