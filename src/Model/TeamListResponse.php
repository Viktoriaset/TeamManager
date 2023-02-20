<?php

namespace App\Model;

class TeamListResponse
{
    /**
     * @param TeamModel[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return TeamModel[]
     */
    public function getTeams(): array
    {
        return $this->items;
    }


}
