<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetPicture;
use Illuminate\Database\Seeder;

class PetPictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for each pet except the first add 1-3 pictures
        Pet::all()->skip(1)->each(function (Pet $pet) {
            PetPicture::factory()->count(1)->create(['pet_id' => $pet->id, 'is_default' => true]);
            PetPicture::factory()->count(rand(0, 2))->create(['pet_id' => $pet->id]);
        });
    }
}
