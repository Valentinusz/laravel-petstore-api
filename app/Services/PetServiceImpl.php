<?php

namespace App\Services;

use App\Contracts\AdoptionService;
use App\Contracts\PetService;
use App\Http\Requests\Pet\StorePetRequest;
use App\Http\Requests\Pet\UpdatePetRequest;
use App\Http\Resources\Pet\PetCollection;
use App\Models\Pet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

readonly class PetServiceImpl implements PetService
{
    public function __construct(private readonly AdoptionService $adoptionService)
    {
    }

    public function findPage(int $page, int $pageSize): LengthAwarePaginator {
        return Pet::with("animal")->paginate(
            perPage: $pageSize,
            page: $page
        );
    }

    public function getById(int $id): Pet
    {
        // TODO: Implement getById() method.
    }

    public function store(StorePetRequest $request): Pet
    {
        // TODO: Implement store() method.
    }

    public function update(Pet $pet, UpdatePetRequest $request): Pet
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $petId): Pet
    {
        DB::transaction(function () use ($petId) {
            $this->adoptionService->destroy($petId);
            Pet::destroy($petId);
        });
    }
}
