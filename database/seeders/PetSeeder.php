<?php

namespace Database\Seeders;

use App\Models\Pet;
use Database\Factories\PetFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dog = DB::table("animals")->where("name", "=", "Dog")->first();

        Pet::factory()
//            ->for($dog)
            ->count(10)
            ->create([
                "animal_id" => 1
            ]);

        $cat = DB::table("animals")->where("name", "=", "Cat")->first();

        Pet::factory()
//            ->for($dog)
            ->count(10)
            ->create([
                "animal_id" => 2
            ]);
    }
}
