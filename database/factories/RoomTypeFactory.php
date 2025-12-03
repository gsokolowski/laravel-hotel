<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'size' => $this->faker->numberBetween(1,2),
            'price' => $this->faker->numberBetween(100,250),
            'amoont' => $this->faker->numberBetween(1,5),
            'created_at' => $this->faker->dateTimeBetween('-9 days', '-4 day'),
            'updated_at' => $this->faker->dateTimeBetween('-2 days', '-1 minute'),
        ];
    }
}
