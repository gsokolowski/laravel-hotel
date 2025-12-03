<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
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
                    ->create();
            });
    }
}
