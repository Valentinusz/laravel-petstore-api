<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetCollection;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pet")]
class PetController extends Controller
{
    #[OA\Get(path: '/api/v1/pets', summary: 'Get a page of pets', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    public function index(): PetCollection
    {
        return new PetCollection(Pet::paginate());
    }

    #[OA\Get(path: '/api/v1/pets/{pet}', summary: 'Get the given pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'pet', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function show(Pet $pet): PetResource
    {
        return new PetResource($pet);
    }

    #[OA\Post(path: '/api/v1/pets', summary: 'Add a new pet', tags: ["Pet"])]
    #[OA\Response(response: 201, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function store()
    {
    }

    #[OA\Put(path: '/api/v1/pets/{pet}', summary: 'Update a pet', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function edit(Pet $pet): PetResource {
        return new PetResource($pet);
    }

    #[OA\Delete(path: '/api/v1/pets/{petId}', summary: 'Delete a pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(int $id) {
        DB::table("pets")->where('id', $id)->delete();

        return response()->noContent();
    }
}
