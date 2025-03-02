<?php

namespace App\Http\Controllers;

use App\Contracts\AdoptionService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionRequest;
use App\Http\Resources\Adoption\AdoptionSummaryCollection;
use App\Http\Resources\Adoption\AdoptionResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\OpenApi\Attributes as OAE;

#[OA\Tag(name: "Adoption")]
class AdoptionController extends Controller
{
    public function __construct(private readonly AdoptionService $adoptionService)
    {
    }

    #[OA\Get(path: '/api/v1/adoptions', summary: 'Get a page of adoptions', tags: ["Adoption"])]
    #[OA\QueryParameter(name: "page", required: false, schema: new OA\Schema(type: "integer"), example: 1)]
    #[OA\QueryParameter(name: "page-size", required: false, schema: new OA\Schema(type: "integer"), example: 20)]
    #[OAE\OkResponse(content: new OA\JsonContent(
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
    #[OA\PathParameter(name: 'adoptionId', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OAE\OkResponse(content: new OA\JsonContent(type: AdoptionResource::class))]
    #[OAE\ErrorResponse(response: 401, description: "Unauthorized")]
    #[OAE\ErrorResponse(response: 404, description: 'Not found')]
    public function show(int $adoptionId): AdoptionResource
    {
        return AdoptionResource::make($this->adoptionService->getById($adoptionId));
    }

    #[OA\Post(
        path: '/api/v1/adoptions',
        operationId: "createAdoption",
        summary: 'Add a new adoption',
        tags: ["Adoption"])]
    #[OA\RequestBody(content: new OA\JsonContent(type: StoreAdoptionRequest::class))]
    #[OAE\CreatedResponse(content: new OA\JsonContent(type: AdoptionResource::class))]
    #[OAE\ErrorResponse(response: 404, description: 'Pet not found')]
    #[OAE\ErrorResponse(response: 409, description: 'Pet is already adopted')]
    public function store(StoreAdoptionRequest $request): AdoptionResource
    {
        return new AdoptionResource($this->adoptionService->store($request));
    }

    #[OA\Put(path: '/api/v1/adoptions/{adoptionId}', summary: 'Update a pet', tags: ["Adoption"])]
    #[OAE\OkResponse(description: 'Updated', content: new OA\JsonContent(type: AdoptionResource::class))]
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
