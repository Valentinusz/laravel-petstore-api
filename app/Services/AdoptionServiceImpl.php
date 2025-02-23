<?php

namespace App\Services;

use App\Contracts\AdoptionService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Models\Adoption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AdoptionServiceImpl implements AdoptionService
{

    function findPage(int $page, int $pageSize): LengthAwarePaginator
    {
        return Adoption::paginate(perPage: $pageSize, page: $page);
    }

    function getById(int $id): Adoption
    {
        $adoption = Adoption::find($id);

        if ($adoption === null) {
            abort(404);
        }

        return $adoption;
    }

    function destroy(int $adoptionId): void
    {
        // TODO: Implement destroy() method.
    }

    function destroyByPetId(int $petId): void
    {
        DB::table('adoptions')->where('pet_id', '=', $petId)->delete();
    }
}
