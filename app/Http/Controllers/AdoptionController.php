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

    #[OA\Get(
        path: '/api/v1/adoptions',
        operationId: 'getAdoptionPage',
        summary: 'Get a page of adoptions',
        tags: ["Adoption"])]
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

    #[OA\Get(
        path: '/api/v1/adoptions/{adoptionId}',
        operationId: "getAdoption",
        summary: 'Get the given adoption',
        tags: ["Adoption"])]
    #[OA\PathParameter(name: 'adoptionId', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OAE\OkResponse(jsonContentType: AdoptionResource::class)]
    #[OAE\UnauthorizedResponse]
    #[OAE\ForbiddenResponse]
    #[OAE\NotFoundResponse(description: 'Not found')]
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
    #[OAE\NotFoundResponse(description: 'Pet not found')]
    #[OAE\ConflictResponse(description: 'Pet is already adopted')]
    public function store(StoreAdoptionRequest $request): AdoptionResource
    {
        return new AdoptionResource($this->adoptionService->store($request));
    }

    #[OA\Put(
        path: '/api/v1/adoptions/{adoptionId}',
        operationId: "updateAdoption",
        summary: 'Update a pet',
        tags: ["Adoption"])]
    #[OAE\OkResponse(description: 'Updated', content: new OA\JsonContent(type: AdoptionResource::class))]
    #[OAE\NotFoundResponse(description: 'Adoption not found')]
    public function update(int $adoptionId, UpdateAdoptionRequest $request): AdoptionResource
    {
        return new AdoptionResource($this->adoptionService->update($adoptionId, $request));
    }

    #[OA\Delete(
        path: '/api/v1/adoptions/{adoptionId}',
        operationId: "deleteAdoption",
        summary: 'Delete an adoption',
        tags: ["Adoption"])]
    #[OA\PathParameter(name: 'adoptionId', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OAE\NoContentResponse(description: 'Adoption deleted')]
    #[OAE\NotFoundResponse(description: 'Adoption does not exist')]
    public function destroy(int $adoptionId)
    {
        $this->adoptionService->destroy($adoptionId);

        return response()->noContent();
    }
}
