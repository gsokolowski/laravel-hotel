<?php

use App\Models\City;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    // Create new hotel for City using Eloquent 
    $city = City::find(1);

    $hotel = $city->hotels()->create([
        'name' => 'Hotel 1',
        'description' => 'Hotel 1 description',
        'city_id' => $city,
    ]);

    // create new hotel but using save method

    $hotel = new Hotel();
    $hotel->name = 'Grand Hotel';
    $hotel->description = 'A luxurious hotel in the heart of the city';
    $hotel->city_id = $city->id;
    $hotel->save();

    $hotel = new Hotel([
        'name' => 'Grand Hotel',
        'description' => 'A luxurious hotel in the heart of the city',
        'city_id' => 1
    ]);
    $hotel->save();

    
    dump($hotel);
    
    


    //dump($result);    
    // return response()->json($result);
});
