<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: "0.0.0", title: "PetStore API - Laravel")]
class StoreController extends Controller
{

    #[OA\Get(
        path: "/v1/stores",
        summary: "Returns all stores",
    )]
    #[OA\Response(response: 200, description: "OK")]
    public function index(): array {
        return [];
    }
}
