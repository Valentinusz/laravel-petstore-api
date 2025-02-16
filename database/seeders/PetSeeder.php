<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make 5-8 pets for each animal category
        Animal::all()->each(function (Animal $animal) {
            Pet::factory()
                ->count(rand(5, 8))
                ->create([
                    "animal_id" => $animal->id
                ]);
        });
    }
}
