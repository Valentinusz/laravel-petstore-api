<?php

namespace Database\Factories;

use App\Models\PetPicture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
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
        $placeholderImagesDisk = Storage::build([
            'driver' => 'local',
            'root' => 'resources\placeholder'
        ]);

        $files = $placeholderImagesDisk->files();
        $fileName = $files[rand(0, count($files) - 1)];

        $file = new UploadedFile($placeholderImagesDisk->path($fileName), $fileName);
        $path = $file->store("pet-pictures", 'public');

        return [
            'url' => $path,
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
