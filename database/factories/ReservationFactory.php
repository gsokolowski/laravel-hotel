<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id' => User::factory(),
            'check_in' => $this->faker->dateTimeBetween('+2 days', '+5 days'),
            'check_out' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'number_of_guests' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'refunded']),
            'notes' => $this->faker->optional(0.8)->sentence(), // 30% chance of having notes
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-10 days', 'now'),
        ];
    }
}
