<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: "0.0", title: "Petstore API")]
#[OA\SecurityScheme(securityScheme: "bearer", type: "http", description: "Bearer token", name: "bearer", scheme: "bearer")]
abstract class Controller
{
    //
}
