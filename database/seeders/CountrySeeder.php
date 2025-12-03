<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 countries and associate random number of cities with each country
        Country::factory()->count(10)->create()
            ->each(function ($country) {
                City::factory()
                    ->count(rand(3, 10))
                    ->for($country)
                    ->create()
                    ->each(function ($city) { // Also fro reach City create 1 to 4 hotels
                        Hotel::factory()
                            ->count(rand(1, 4))
                            ->for($city)
                            ->create()
                            ->each(function ($hotel) {
                                Room::factory()
                                ->count(rand(1, 4))
                                ->for($hotel)
                                ->create();                                
                            });        
                    });
            });
    }
}


