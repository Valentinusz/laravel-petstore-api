<?php

namespace Database\Factories;

use App\Models\PetPicture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<PetPicture>
 */
class PetPictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $files = Storage::allFiles("placeholder");

        $file = $files[rand(0, count($files) - 1)];

        $file->store('images');

        return [
            ''
        ];
    }

    public function forCat(): static
    {
        return $this->state(function (array $attributes) {
            $catFile = Storage::get($this->faker->randomElement(['cat-1', 'cat-2']));

            $path = Storage::put("pictures", $catFile);

            return new Sequence([
                'url' => $path,
            ]);
        });
    }
}
