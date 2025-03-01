<?php

namespace App\Contracts;

use App\Http\Requests\Adoption\StoreAdoptionRequest;
use App\Http\Requests\Adoption\UpdateAdoptionRequest;
use App\Models\Adoption;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface AdoptionService
{
    /**
     * @param int $page
     * @param int $pageSize
     * @return LengthAwarePaginator<Adoption>
     */
    function findPage(int $page, int $pageSize): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Adoption
     * @throws NotFoundHttpException if the adoption does not exist
     */
    function getById(int $id): Adoption;

    /**
     * @param StoreAdoptionRequest $adoption
     * @return Adoption
     */
    function store(StoreAdoptionRequest $adoption): Adoption;

    /**
     * @param int $id
     * @param UpdateAdoptionRequest $updatedAdoption
     * @return Adoption
     */
    function update(int $id, UpdateAdoptionRequest $updatedAdoption): Adoption;

    /**
     * @param int $adoptionId
     * @return void
     */
    function destroy(int $adoptionId): void;

    /**
     * @param int $petId
     * @return void
     */
    function destroyByPetId(int $petId): void;
}
