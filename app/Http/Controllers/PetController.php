<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Resources\PetCollection;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pet")]
class PetController extends Controller
{
    #[OA\Get(path: '/api/v1/pets', operationId: "getPets", summary: 'Get a page of pets', tags: ["Pet"])]
    #[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Parameter(name: 'page_size', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 20)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    public function index(Request $request): PetCollection
    {

        return new PetCollection(
            Pet::paginate(
                perPage: $request->query('page_size', 20),
                page: $request->query('page', 0)
            )
        );
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
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StorePetRequest"))]
    #[OA\Response(response: 201, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function store(StorePetRequest $request)
    {
        $validated = $request->validated();

        \Illuminate\Log\log($validated);

        return response()->json([
            'name' => $validated["name"],
        ], 201);
    }

    #[OA\Put(path: '/api/v1/pets/{pet}', summary: 'Update a pet', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function update(Pet $pet): PetResource
    {
        return new PetResource($pet);
    }

    #[OA\Delete(path: '/api/v1/pets/{petId}', summary: 'Delete a pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(int $id)
    {
        DB::table("pets")->where('id', $id)->delete();

        return response()->noContent();
    }
}
