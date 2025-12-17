<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Part;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $part = Part::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'user_id' => User::factory(),
            'part_id' => $part->id,
            'quantity' => $quantity,
            'total_price' => $part->price * $quantity,
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence()
        ];
    }
}