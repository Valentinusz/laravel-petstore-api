<?php

namespace App\Http\Controllers;

use App\Contracts\UserService;
use App\Http\Resources\User\UserResource;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[OA\Get(path: '/api/v1/users/current')]
    #[OA\Response(response: 200, description: "OK", content: new OA\JsonContent(ref: "#/components/schemas/User"))]
    public function current(): UserResource
    {
        return UserResource::make($this->userService->getCurrentUserWithRolesAndPermissions());
    }
}
