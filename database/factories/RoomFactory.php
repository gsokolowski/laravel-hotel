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
            'name' => rtrim($this->faker->text(10), '.'), // dot at the end
            'description' => rtrim($this->faker->sentence(9), '.'), // dot at the end
            'room_type_id' => \App\Models\RoomType::factory()->create(), // automatically create room_type_id
            'created_at' => $this->faker->dateTimeBetween('-10 days', '-5 day'),
            'updated_at' => $this->faker->dateTimeBetween('-3 days', '-1 hour')
        ];
    }
}
