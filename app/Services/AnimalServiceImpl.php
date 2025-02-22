<?php

namespace App\Services;

use App\Contracts\AnimalService;
use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Models\Animal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class AnimalServiceImpl implements AnimalService
{
    public function findAll(): Collection
    {
        return Animal::all();
    }

    public function getById(int $id): Animal
    {
        $animal = Animal::find($id);

        if ($animal === null) {
            App::abort(404);
        }

        return $animal;
    }

    public function store(StoreAnimalRequest $request): Animal
    {
        return Animal::create([
            'name' => $request->name
        ]);
    }

    public function update(int $id, UpdateAnimalRequest $request): Animal {
        $animal = $this->getById($id);

        $animal->name = $request->name;

        $animal->save();

        return $animal;
    }

    public function destroy(int $id): void
    {
        $animal = $this->getById($id);

        if ($animal->pets()->exists()) {
            abort(409);
        }

        $animal->delete();
    }
}
