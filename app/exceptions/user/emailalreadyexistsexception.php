<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class EmailAlreadyExistsException extends BaseException
{
    public function __construct(string $email)
    {
        parent::__construct(
            "Email already exists",
            ['email' => $email]
        );
    }
}
