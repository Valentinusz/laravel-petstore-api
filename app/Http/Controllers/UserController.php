<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class UserController extends Controller
{

    #[OA\Get(path: '/api/v1/users/current')]
    #[OA\Response(response: 200, description: "OK", content: new OA\JsonContent(ref: "#/components/schemas/User"))]
    public function current(): UserResource
    {
        return UserResource::make(Auth::user()->load("roles"));
    }
}
