<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use phpDocumentor\Reflection\DocBlock\Tags\Property;

#[OA\Info(version: "0.0", title: "Petstore API")]
#[OA\SecurityScheme(securityScheme: "bearer", type: "http", description: "Bearer token", name: "bearer", scheme: "bearer")]
#[OA\Schema(schema: "PageMeta", required: ["current_page", "from", "last_page", "path", "per_page", "to", "total"], properties: [
    new OA\Property(property: "current_page", description: "Index of the current page. Indexed from 1.", type: "integer", example: 1),
    new OA\Property(property: "from", description: "Index of the first item of the page among all items. Equal to (page * per_page) + 1.", type: "integer", example: 6),
    new OA\Property(property: "last_page", description: "Index of the last page", type: "integer", example: 4),
    new OA\Property(property: 'path', description: "URL of the current endpoint", type: "string", example: "http://127.0.0.1:8000/api/v1/pets"),
    new OA\Property(property: 'per_page', description: "Page size", type: "string", example: 5),
    new OA\Property(property: 'to', description: "Index of the last item of the page among all items. Equal to page * (per_page + 1).", type: 'integer', example: 10),
    new OA\Property(property: 'total', description: "Total count of items", type: "integer", example: 20),
])]
abstract class Controller
{
    //
}
