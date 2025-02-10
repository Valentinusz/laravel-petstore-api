<?php

use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PetPictureController;
use App\Http\Controllers\UserController;
use App\Http\Resources\AnimalCollection;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/animals', function () {
        return AnimalCollection::collection(Animal::all());
    });

    Route::prefix('users')->group(function () {
        Route::get('/current', [UserController::class, 'current']);
        Route::apiResource('users', UserController::class)->only(['index', 'show']);
    });

    Route::apiResources([
        'pets' => PetController::class,
        'adoptions' => AdoptionController::class,
    ]);

    Route::apiResource("pets.pictures", PetPictureController::class)->only(['store', 'destroy']);
});
