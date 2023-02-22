<?php

namespace App\Exception;

class GroupNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Team not found');
    }
}
