<?php

namespace App\Exception;

class TeamNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Team not found');
    }
}
