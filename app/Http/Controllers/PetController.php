<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetCollection;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pet")]
class PetController extends Controller
{
    #[OA\Get(path: '/api/v1/pets', operationId: "getPets", summary: 'Get a page of pets', tags: ["Pet"])]
    #[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Parameter(name: 'page-size', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 20)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(
        title: "PageOfPet",
        required: ["data", "meta"],
        properties: [
            new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Pet")),
            new OA\Property(property: "meta", ref: "#/components/schemas/PageMeta")
        ]
    ))]
    public function index(Request $request): PetCollection
    {
        return new PetCollection(
            Pet::with("animal")->paginate(
                perPage: $request->query('page-size', 20),
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

        Pet::create([
            'name' => $validated['name'],
            'is_male' => $validated['gender'] === 'male',
            'birth_date' =>  $validated['birth_date'],
            'description' => $validated['description'],
            'animal_id' => $validated['animal_id']
        ]);

        return response()->json([
            'name' => $validated["name"],
        ], 201);
    }

    #[OA\Put(path: '/api/v1/pets/{pet}', summary: 'Update a pet', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function update(Pet $pet, UpdatePetRequest $request): PetResource
    {
        $validated = $request->validated();

        $pet->name = $validated["name"];
        $pet->is_male = $validated["is_male"];
        $pet->birth_date = $validated["birth_date"];
        $pet->description = $validated["description"];
        $pet->animal_id = $validated["animal"];

        return new PetResource($pet);
    }

    #[OA\Delete(path: '/api/v1/pets/{pet}', summary: 'Delete a pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(Pet $pet)
    {
        $pet->
        $pet->delete();

        return response()->noContent();
    }
}
