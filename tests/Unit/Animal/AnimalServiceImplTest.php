<?php

use App\Models\Animal;
use App\Services\AnimalServiceImpl;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

$animalServiceImpl = new AnimalServiceImpl();

uses(TestCase::class);

test('findAll should return all animals', function () use ($animalServiceImpl) {
    $animals = new \Illuminate\Support\Collection([
        new Animal([
            'id' => 1,
            'name' => 'Cat'
        ]),
        new Animal([
            'id' => 2,
            'name' => 'Dog'
        ])
    ]);

    Mockery::mock(Animal::class)
        ->shouldReceive('all')
        ->andReturn($animals);

    expect($animalServiceImpl->findAll())->toEqual($animals);
});

describe('getById should', function () use ($animalServiceImpl) {
    $animalId = 1;

    test("abort when animal is not found", function () use ($animalId, $animalServiceImpl) {
        Mockery::mock('overload:App\Models\Animal')
            ->shouldReceive('find')
            ->withArgs([$animalId])
            ->andReturn(null);

//        App::shouldReceive('abort')->withArgs([404])->once();

        expect($animalServiceImpl->getById($animalId))->toThrow(NotFoundHttpException::class);
    });

    test("return animal when found", function () use ($animalId, $animalServiceImpl) {
        $animal = new Animal([
            "id" => 1,
            "name" => "Cat"
        ]);

        Mockery::mock(Animal::class)
            ->shouldReceive('all')
            ->withArgs([$animalId])
            ->andReturn($animal);

        expect($animalServiceImpl->getById($animalId))->toEqual($animal);
    });
});
