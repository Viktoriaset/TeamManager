<?php

namespace App\Model;

class UserListResponse
{
    /**
     * @var UserModel[]
     */
    private array $items;

    /**
     * @param UserModel[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return UserModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
