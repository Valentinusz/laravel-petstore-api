<?php

namespace App\Http\Controllers;

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
    #[OA\Get(path: '/api/v1/adoptions', summary: 'Get a page of adoptions', tags: ["Adoption"])]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    public function index(Request $request) {
        return new AdoptionCollection(Adoption::paginate());
    }

    #[OA\Get(path: '/api/v1/adoptions/{adoption}', summary: 'Get the given pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'pet', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 200, description: 'OK', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function show(Adoption $adoption)
    {
        return AdoptionResource::make($adoption);
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
    public function update(UpdateAdoptionRequest $request) {
    }

    #[OA\Delete(path: '/api/v1/adoptions/{adoption}', summary: 'Delete a pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(Adoption $adoption) {
        $adoption->delete();

        return response()->noContent();
    }
}
