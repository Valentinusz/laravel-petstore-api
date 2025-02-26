<?php

namespace App\Services;

use App\Contracts\AdoptionService;
use App\Contracts\PetService;
use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Models\Adoption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AdoptionServiceImpl implements AdoptionService
{
    public function __construct(private readonly PetService $petService)
    {
    }

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

    public function store(StoreAdoptionRequest $request): Adoption {
        $pet = $this->petService->getById($request->pet_id);

        return DB::transaction(function () use ($request, $pet) {
            $adoption = Adoption::create($request->validated());

            $pet->adoption_id = $adoption->id;

            return $adoption;
        });
    }

    function destroy(int $adoptionId): void
    {
        $adoption = $this->getById($adoptionId);

        DB::transaction(function () use ($adoption) {
            $pet = $adoption->pet();

            $adoption->delete();
        });
    }

    function destroyByPetId(int $petId): void
    {
        DB::table('adoptions')->where('pet_id', '=', $petId)->delete();
    }
}
