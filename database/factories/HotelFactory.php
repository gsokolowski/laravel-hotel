<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName(),
            'description' => rtrim($this->faker->sentence(4), '.'), // dot at the end
            'created_at' => $this->faker->dateTimeBetween('-20 days', '-10 day'),
            'updated_at' => $this->faker->dateTimeBetween('-5 days', '-1 day')
        ];
    }
}
