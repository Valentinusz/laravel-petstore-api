<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetCollection;
use App\Models\Pet;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pet")]
class PetController extends Controller
{
    #[OA\Get(path: '/api/v1/pets', summary: 'Get a page of pets', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'OK')]
    public function index(): PetCollection {
        return new PetCollection(Pet::paginate());
    }
}
