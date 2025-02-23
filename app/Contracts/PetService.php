<?php

namespace App\Contracts;

use App\Http\Requests\Pet\StorePetRequest;
use App\Http\Requests\Pet\UpdatePetRequest;
use App\Models\Pet;
use Illuminate\Pagination\LengthAwarePaginator;

interface PetService
{
    /**
     * @param int $page
     * @param int $pageSize
     * @return LengthAwarePaginator<number, LengthAwarePaginator>
     */
    public function findPage(int $page, int $pageSize): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Pet
     */
    public function getById(int $id): Pet;

    /**
     * @param StorePetRequest $request
     * @return Pet
     */
    public function store(StorePetRequest $request): Pet;

    /**
     * @param int $petId
     * @param UpdatePetRequest $request
     * @return Pet
     */
    public function update(int $petId, UpdatePetRequest $request): Pet;

    /**
     * @param int $petId
     * @return void
     */
    public function destroy(int $petId): void;
}
