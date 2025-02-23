<?php

namespace App\Contracts;

use App\Models\User;

interface UserService
{
    /**
     * @return User
     */
    function getCurrentUserWithRolesAndPermissions(): User;
}
