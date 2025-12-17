<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Part>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'code' => strtoupper($this->faker->bothify('???-###')),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 50),
            'category' => $this->faker->randomElement(['Engine', 'Braking', 'Suspension', 'Electrical System', 'Wheels']),
            'manufacturer' => $this->faker->company(),
            'images' => [$this->faker->imageURL(), $this->faker->imageURL()],
        ];
    }
}
