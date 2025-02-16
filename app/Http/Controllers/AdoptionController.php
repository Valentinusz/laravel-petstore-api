<?php

namespace App\Http\Controllers;

use App\Http\Resources\Adoption\AdoptionCollection;
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
    public function show()
    {
    }

    #[OA\Post(path: '/api/v1/adoptions', summary: 'Add a new pet', tags: ["Adoption"])]
    #[OA\Response(response: 201, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function store()
    {
    }

    #[OA\Put(path: '/api/v1/adoptions/{adoption}', summary: 'Update a pet', tags: ["Adoption"])]
    #[OA\Response(response: 200, description: 'Created', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'OK')]
    public function edit() {
    }

    #[OA\Delete(path: '/api/v1/adoptions/{adoptionId}', summary: 'Delete a pet', tags: ["Adoption"])]
    #[OA\Parameter(name: 'petId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1)]
    #[OA\Response(response: 204, description: 'No content', content: new OA\MediaType('application/json'))]
    #[OA\Response(response: 404, description: 'Not found')]
    public function destroy(int $id) {
        DB::table("pets")->where('id', $id)->delete();

        return response()->noContent();
    }
}
