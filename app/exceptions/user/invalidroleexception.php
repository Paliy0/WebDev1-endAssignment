<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class InvalidRoleException extends BaseException
{
    private string $attemptedRole;
    private array $validRoles;

    public function __construct(string $attemptedRole, array $validRoles)
    {
        $this->attemptedRole = $attemptedRole;
        $this->validRoles = $validRoles;

        parent::__construct(
            "Invalid role provided",
            [
                'attempted_role' => $attemptedRole,
                'valid_roles' => $validRoles
            ]
        );
    }

    public function getAttemptedRole(): string
    {
        return $this->attemptedRole;
    }

    public function getValidRoles(): array
    {
        return $this->validRoles;
    }
}
