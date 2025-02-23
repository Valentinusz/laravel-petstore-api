<?php

use App\Models\Animal;
use App\Services\AnimalServiceImpl;
use Illuminate\Support\Collection;
use Tests\TestCase;

uses(TestCase::class);

$animalServiceImpl = new AnimalServiceImpl();

/**
 * @runInSeparateProcess
 * @preserveGlobalState disabled
 */
describe('findAll', function () use ($animalServiceImpl) {
    test('findAll should return all animals', function () use ($animalServiceImpl) {
        $animalMock = Mockery::mock('overload:App\Models\Animal');

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

        $animalMock->shouldReceive('all')->andReturn($animals);

        expect($animalServiceImpl->findAll())->toEqual($animals);

        Mockery::close();
    });
});

describe('getById should', function () use ($animalServiceImpl) {
    $animalId = 1;

    test("abort when animal is not found", function () use ($animalId, $animalServiceImpl) {
        Mockery::mock('overload:App\Models\Animal')
            ->shouldReceive('find')
            ->with($animalId)
            ->andReturn(null);

        App::shouldReceive('abort')->with(404)->once()->andThrow(new Exception());

        expect(fn() => $animalServiceImpl->getById($animalId))->toThrow(Exception::class);
    });

    test("return animal when found", function () use ($animalId, $animalServiceImpl) {
        $animalMock = Mockery::mock('overload:App\Models\Animal');

        $animal = new Animal([
            "id" => 1,
            "name" => "Cat"
        ]);

        $animalMock
            ->shouldReceive('find')
            ->with($animalId)
            ->andReturn($animal);

        expect($animalServiceImpl->getById($animalId))->toEqual($animal);
    });
});
