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
        return Pet::findOrFail($id);
    }

    public function store(StorePetRequest $request): Pet
    {
        $validated = $request->validated();

        return Pet::create([
            'name' => $validated['name'],
            'is_male' => $validated['gender'] === 'male',
            'birth_date' => $validated['birth_date'],
            'description' => $validated['description'],
            'animal_id' => $validated['animal_id']
        ]);
    }

    public function update(int $petId, UpdatePetRequest $request): Pet
    {
        $pet = $this->getById($petId);
        $validated = $request->validated();

        $pet->name = $validated["name"];
        $pet->is_male = $validated["is_male"];
        $pet->birth_date = $validated["birth_date"];
        $pet->description = $validated["description"];
        $pet->animal_id = $validated["animal"];

        $pet->save();

        return $pet;
    }

    public function destroy(int $petId): void
    {
        DB::transaction(function () use ($petId) {
            $this->adoptionService->destroy($petId);
            Pet::destroy($petId);
        });
    }
}
