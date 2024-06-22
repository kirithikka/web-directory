<?php

namespace App\Enums;

enum UserType : int
{
    CASE ADMIN = 1;
    CASE CUSTOMER = 2;

    /**
     * Checks if the user is an admin
     *
     */
    public function isAdmin()
    {
        return $this == self::ADMIN;
    }
}