<?php

namespace App\Http\Controllers;

use App\Contracts\PetService;
use App\Http\Requests\Pet\StorePetRequest;
use App\Http\Requests\Pet\UpdatePetRequest;
use App\Http\Resources\Pet\PetCollection;
use App\Http\Resources\Pet\PetResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pet")]
class PetController extends Controller
{
    /**
     * @param PetService $petService
     */
    public function __construct(private readonly PetService $petService)
    {
    }

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
        return new PetCollection($this->petService->findPage(page: $request->query('page', 0), pageSize: $request->query('page-size', 20)));
    }

    #[OA\Get(path: '/api/v1/pets/{petId}', summary: 'Get the given pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function show(int $petId): PetResource
    {
        return new PetResource($this->petService->getById($petId));
    }

    #[OA\Post(path: '/api/v1/pets', summary: 'Add a new pet', tags: ["Pet"])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StorePetRequest"))]
    #[OA\Response(response: 201, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function store(StorePetRequest $request)
    {
        return response()->json(
            new PetResource($this->petService->store($request)),
            201
        );
    }

    #[OA\Put(path: '/api/v1/pets/{petId}', summary: 'Update a pet', tags: ["Pet"])]
    #[OA\Response(response: 200, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function update(int $petId, UpdatePetRequest $request): PetResource
    {
        return new PetResource($this->petService->update($petId, $request));
    }

    #[OA\Delete(path: '/api/v1/pets/{petId}', summary: 'Delete a pet', tags: ["Pet"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(int $petId)
    {
        $this->petService->destroy($petId);

        return response()->noContent();
    }
}
