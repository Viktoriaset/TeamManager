<?php

namespace App\Model;

class MemberListResponse
{
    /**
     * @param MemberModel[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return MemberModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


}
