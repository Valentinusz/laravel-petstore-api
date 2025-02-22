<?php

namespace App\Contracts;

use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Models\Animal;
use Illuminate\Support\Collection;

interface AnimalService
{
    /**
     * @return Collection<Animal>
     */
    public function findAll(): Collection;

    /**
     * @param int $id
     * @return Animal
     */
    public function getById(int $id): Animal;

    /**
     * @param StoreAnimalRequest $request
     * @return Animal
     */
    public function store(StoreAnimalRequest $request): Animal;

    /**
     * @param int $id
     * @param UpdateAnimalRequest $request
     * @return Animal
     */
    public function update(int $id, UpdateAnimalRequest $request): Animal;

    /**
     * @param int $id
     */
    public function destroy(int $id): void;
}
