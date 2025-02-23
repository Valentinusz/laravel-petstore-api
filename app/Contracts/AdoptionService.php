<?php

namespace App\Contracts;

//use App\Http\Requests\Adoption\StoreAdoptionRequest;
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
     * @throws NotFoundHttpException if the adoption does not exist
     * @return Adoption
     */
    function getById(int $id): Adoption;

//    /**
//     * @param StoreAdoptionRequest $adoption
//     * @return Adoption
//     */
//    function store(StoreAdoptionRequest $adoption): Adoption;
//
//    /**
//     * @param int $id
//     * @param StoreAdoptionRequest $updatedAdoption
//     * @return Adoption
//     */
//    function update(int $id, StoreAdoptionRequest $updatedAdoption): Adoption;
//
//    /**
//     * @param int $id
//     * @return void
//     */
//    function destroy(int $id): void;
}
