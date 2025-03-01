<?php

namespace App\Http\Controllers;

use App\Contracts\AdoptionService;
use App\Contracts\PetService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionRequest;
use App\Http\Resources\Adoption\AdoptionSummaryCollection;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Models\Adoption;
use App\OpenApi\ErrorResponse;
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
    #[OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 1)]
    #[OA\Parameter(name: "page-size", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 20)]
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
        return new AdoptionSummaryCollection(
            $this->adoptionService->findPage(
                page: $request->query('page', 1),
                pageSize: $request->query("page-size", 20)
            ));
    }

    #[OA\Get(path: '/api/v1/adoptions/{adoptionId}', summary: 'Get the given pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'adoptionId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 401, description: "Unauthorized")]
//    #[OA\Response(response: 404, description: 'Not found')]
    #[ErrorResponse(response: 404, description: 'Pet not found')]
    public function show(int $adoptionId)
    {
        return AdoptionResource::make($this->adoptionService->getById($adoptionId));
    }

    #[OA\Post(
        path: '/api/v1/adoptions',
        operationId: "createAdoption",
        summary: 'Add a new adoption',
        tags: ["Adoption"])]
    #[OA\Response(
        response: 201,
        description: 'Created',
        content: new OA\JsonContent(ref: "#/components/schemas/Adoption"))]
    #[ErrorResponse(response: 404, description: 'Pet not found')]
    #[ErrorResponse(response: 404, description: 'Pet not found')]
    #[ErrorResponse(response: 404, description: 'Pet not found')]
    #[OA\Response(response: 409, description: 'Pet is already adopted', content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse"))]
    public function store(StoreAdoptionRequest $request)
    {
        return new AdoptionResource($this->adoptionService->store($request));
    }

    #[OA\Put(path: '/api/v1/adoptions/{adoptionId}', summary: 'Update a pet', tags: ["Adoption"])]
    #[OA\Response(response: 200, description: 'Updated', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Adoption not found')]
    public function update(int $adoptionId, UpdateAdoptionRequest $request): AdoptionResource
    {
        return new AdoptionResource($this->adoptionService->update($adoptionId, $request));
    }

    #[OA\Delete(path: '/api/v1/adoptions/{adoptionId}', summary: 'Delete an adoption', tags: ["Adoption"])]
    #[OA\Parameter(name: 'adoptionId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'Adoption deleted', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Adoption does not exist')]
    public function destroy(int $adoptionId)
    {
        $this->adoptionService->destroy($adoptionId);

        return response()->noContent();
    }
}
