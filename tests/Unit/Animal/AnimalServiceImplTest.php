<?php

use App\Models\Animal;
use App\Services\AnimalServiceImpl;
use Illuminate\Support\Collection;
use Tests\TestCase;

$animalServiceImpl = new AnimalServiceImpl();

uses(TestCase::class);


/**
 * @runInSeparateProcess
 * @preserveGlobalState disabled
 */
describe('findAll', function () use ($animalServiceImpl) {
    test('findAll should return all animals', function () use ($animalServiceImpl) {
        $animalMock = Mockery::mock(Animal::class)
            ->shouldReceive('all');

        $animals = new Collection([
            new Animal([
                'id' => 1,
                'name' => 'Cat'
            ]),
            new Animal([
                'id' => 2,
                'name' => 'Dog'
            ])
        ]);

        $animalMock->andReturn($animals);

        expect($animalServiceImpl->findAll())->toEqual($animals);
    });
});

describe('getById should', function () use ($animalServiceImpl) {
    $animalId = 1;

    test("abort when animal is not found", function () use ($animalId, $animalServiceImpl) {
        Mockery::mock('overload:App\Models\Animal')
            ->shouldReceive('find')
            ->withArgs([$animalId])
            ->andReturn(null);

        App::shouldReceive('abort')->with(404)->once()->andThrow(new Exception());

        expect(fn() => $animalServiceImpl->getById($animalId))->toThrow(Exception::class);
    });

    test("return animal when found", function () use ($animalId, $animalServiceImpl) {
        $animalMock = Mockery::mock('overload', Animal::class);

        $animal = new Animal([
            "id" => 1,
            "name" => "Cat"
        ]);

        $animalMock
            ->shouldReceive('all')
            ->withArgs([$animalId])
            ->andReturn($animal);

        expect($animalServiceImpl->getById($animalId))->toEqual($animal);
    });
});
