<?php

namespace App\Http\Controllers;

use App\Contracts\AnimalService;
use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Http\Resources\Animal\AnimalDetailsResource;
use App\Http\Resources\Animal\AnimalSummaryResource;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Animal")]
class AnimalController extends Controller
{
    public function __construct(private readonly AnimalService $animalService)
    {
    }

    #[OA\Get(path: "/api/v1/animals", summary: "Get all animals", tags: ["Animal"])]
    #[OA\Response(
        response: 200,
        description: "OK",
        content: new OA\JsonContent(ref: "#/components/schemas/AnimalSummaryCollection")
    )]
    public function index()
    {
        return AnimalSummaryResource::collection($this->animalService->findAll());
    }

    #[OA\Get(path: "/api/v1/animals/{animalId}", summary: "Get the given animal", tags: ["Animal"])]
    #[OA\Response(response: 200, description: "OK")]
    #[OA\Response(response: 404, description: "Not found")]
    public function show(int $animalId)
    {
        return new AnimalDetailsResource($this->animalService->getById($animalId));
    }

    #[OA\Post(path: "/api/v1/animals", summary: "Add a new animal", tags: ["Animal"])]
    #[OA\Response(response: 201, description: "Created", content: new OA\MediaType("application/json"))]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StoreAnimalRequest"))]
    public function store(StoreAnimalRequest $request)
    {
        return response(content: $this->animalService->store($request), status: 201);
    }

    #[OA\Put(path: "/api/v1/animals/{animalId}", summary: "Update the given animal", tags: ["Animal"])]
    #[OA\Response(response: 200, description: "OK")]
    #[OA\Response(response: 404, description: "Not found")]
    public function update(int $animalId, UpdateAnimalRequest $request)
    {
        return $this->animalService->update($animalId, $request);
    }

    #[OA\Delete(path: "/api/v1/animals/{animalId}", summary: "Delete the given animal", tags: ["Animal"])]
    #[OA\Parameter(name: "animal", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 1)]
    #[OA\Response(response: 204, description: "No content", content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: "Not found")]
    #[OA\Response(response: 409, description: "Conflict - A pet exists for the animal type")]
    public function destroy(int $animalId)
    {
        $this->destroy($animalId);

        return response(status: 204);
    }
}
