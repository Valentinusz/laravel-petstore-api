<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Resources\AnimalDetailsResource;
use App\Http\Resources\AnimalSummaryResource;
use App\Models\Animal;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Animal")]
class AnimalController extends Controller
{
    #[OA\Get(path: "/api/v1/animals", summary: "Get all animals", tags: ["Animal"])]
    #[OA\Response(
        response: 200,
        description: "OK",
        content: new OA\JsonContent(ref: "#/components/schemas/AnimalSummaryCollection")
    )]
    public function index()
    {
        return AnimalSummaryResource::collection(Animal::all());
    }

    #[OA\Get(path: "/api/v1/animals/{animal}", summary: "Get the given animal", tags: ["Animal"])]
    #[OA\Response(response: 200, description: "OK")]
    #[OA\Response(response: 404, description: "Not found")]
    public function show(Animal $animal)
    {
        return new AnimalDetailsResource($animal);
    }

    #[OA\Post(path: "/api/v1/animals", summary: "Add a new animal", tags: ["Animal"])]
    #[OA\Response(response: 201, description: "Created", content: new OA\MediaType("application/json"))]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StoreAnimalRequest"))]
    public function store(StoreAnimalRequest $request)
    {
        Animal::create([
            'name' => $request->name
        ]);

        return response(status: 201);
    }

    #[OA\Put(path: "/api/v1/animals/{animal}", summary: "Update the given animal", tags: ["Animal"])]
    #[OA\Response(response: 200, description: "OK")]
    #[OA\Response(response: 404, description: "Not found")]
    public function update(Animal $animal, StoreAnimalRequest $request)
    {
        $animal->name = $request->name;

        $animal->save();
    }

    #[OA\Delete(path: "/api/v1/animals/{animal}", summary: "Delete the given animal", tags: ["Animal"])]
    #[OA\Parameter(name: "animal", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 1)]
    #[OA\Response(response: 204, description: "No content", content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: "Not found")]
    #[OA\Response(response: 409, description: "Conflict - A pet exists for the animal type")]
    public function destroy(Animal $animal)
    {
        if ($animal->pets()->exists()) {
            return response(status: 409);
        }

        $animal->delete();

        return response(status: 204);
    }
}
