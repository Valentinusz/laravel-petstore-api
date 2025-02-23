<?php

namespace App\Services;

use App\Contracts\AdoptionService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Models\Adoption;
use Illuminate\Pagination\LengthAwarePaginator;

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

    function store(StoreAdoptionRequest $adoption): Adoption
    {
        // TODO: Implement store() method.
    }

    function update(int $id, StoreAdoptionRequest $updatedAdoption): Adoption
    {
        // TODO: Implement update() method.
    }

    function destroy(int $id): void
    {
        // TODO: Implement destroy() method.
    }
}
