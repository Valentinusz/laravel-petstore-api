<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Animal::create([
            "name" => "Hamster"
        ]);

        Animal::create([
            "name" => "Parrot"
        ]);
    }
}
