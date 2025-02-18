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
        $files = Storage::disk("local")->files("placeholder");
        $file = $files[rand(0, count($files) - 1)];

        \Log::info($file);

        $fileName = \File::basename($file);

        Storage::copy(Storage::disk("local")->get($file), Storage::disk("public")->path("pet-pictures/$fileName"));

        return [
            'url' => $this->faker->url(),
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
