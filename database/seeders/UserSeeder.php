<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                // Create 1-3 reservations for each user
                $reservations = Reservation::factory()
                    ->count(rand(1, 3))
                    ->for($user)
                    ->create();
                
                // Attach rooms to each reservation
                foreach ($reservations as $reservation) {
                    // Get random room IDs from existing rooms (1-3 rooms per reservation)
                    $roomIds = Room::inRandomOrder()
                        ->limit(rand(1, 3))
                        ->pluck('id')
                        ->toArray();
                    
                    // Attach rooms to reservation with random status
                    $pivotData = [];
                    foreach ($roomIds as $roomId) {
                        $pivotData[$roomId] = ['status' => (bool) rand(0, 1)];
                    }
                    $reservation->rooms()->attach($pivotData);
                }
            });
    }
}
