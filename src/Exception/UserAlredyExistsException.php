<?php

namespace App\Exception;

class UserAlredyExistsException extends \RuntimeException
{

    public function __construct()
    {
        parent::__construct('User already exists');
    }
}
