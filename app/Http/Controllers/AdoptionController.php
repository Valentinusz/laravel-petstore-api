<?php

namespace App\Http\Controllers;

use App\Contracts\AdoptionService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionRequest;
use App\Http\Resources\Adoption\AdoptionCollection;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Adoption")]
class AdoptionController extends Controller
{
    public function __construct(private readonly AdoptionService $adoptionService)
    {
    }

    #[OA\Get(path: '/api/v1/adoptions', summary: 'Get a page of adoptions', tags: ["Adoption"])]
    #[Oa\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 1)]
    #[Oa\Parameter(name: "page-size", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 20)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(
        title: "PageOfAdoption",
        required: ["data", "meta"],
        properties: [
            new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Adoption")),
            new OA\Property(property: "meta", ref: "#/components/schemas/PageMeta")
        ]
    ))]
    public function index(Request $request)
    {
        return new AdoptionCollection(
            $this->adoptionService->findPage(
                page: $request->query('page', 1),
                pageSize: $request->query("page-size", 20)
            ));
    }

    #[OA\Get(path: '/api/v1/adoptions/{adoptionId}', summary: 'Get the given pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'adoptionId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function show(int $adoptionId)
    {
        return AdoptionResource::make($this->adoptionService->getById($adoptionId));
    }

    #[OA\Post(path: '/api/v1/adoptions', summary: 'Add a new pet', tags: ["Adoption"])]
    #[OA\Response(response: 201, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Pet not found')]
    #[OA\Response(response: 409, description: 'Pet is already adopted')]
    public function store(StoreAdoptionRequest $request)
    {

    }

    #[OA\Put(path: '/api/v1/adoptions/{adoption}', summary: 'Update a pet', tags: ["Adoption"])]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Adoption not found')]
    public function update(UpdateAdoptionRequest $request)
    {
    }

    #[OA\Delete(path: '/api/v1/adoptions/{adoption}', summary: 'Delete a pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

        return response()->noContent();
    }
}
