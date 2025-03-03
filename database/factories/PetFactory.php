<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'is_male' => $this->faker->boolean(),
            'birth_date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'available' => true,
        ];
    }
}
