<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => fake()->unique()->numberBetween(1, 8),
            'price' => fake()->numberBetween(100, 100),
            'vacancy' => fake()->boolean(true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
