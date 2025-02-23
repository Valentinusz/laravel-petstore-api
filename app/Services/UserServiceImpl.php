<?php

namespace App\Services;

use App\Contracts\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserServiceImpl implements UserService
{
    function getCurrentUserWithRolesAndPermissions(): User
    {
        return Auth::user()->load("roles", "permissions");
    }
}
