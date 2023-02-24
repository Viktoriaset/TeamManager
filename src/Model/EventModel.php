<?php

namespace App\Model;

class EventModel
{
    private int $id;

    private int $datetime;

    private bool $visited;

    private string $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDatetime(): int
    {
        return $this->datetime;
    }

    public function setDatetime(int $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }


    public function isVisited(): bool
    {
        return $this->visited;
    }

    public function setVisited(bool $visited): self
    {
        $this->visited = $visited;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
