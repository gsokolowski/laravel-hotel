<?php

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $checkIn = '2025-12-09';
    $checkOut = '2025-12-16';
    $cityName = 'Port Rico';
    $amoont = 2;
    $size = 2; // double room
    
    // Query Builder
    $result = DB::table('rooms')
    ->select('rooms.*', 'hotels.name as hotel_name', 'room_types.size as room_type_size', 'cities.name as city_name')
    ->leftJoin('hotels', 'rooms.hotel_id', '=', 'hotels.id')
    ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
    ->leftJoin('cities', 'hotels.city_id', '=', 'cities.id')
    ->whereNotExists(function ($query) use ($checkIn, $checkOut) {
        $query->select('reservations.id')
            ->from('reservations')
            ->join('reservation_room', 'reservations.id', '=', 'reservation_room.reservation_id')
            ->whereRaw('rooms.id = reservation_room.room_id')
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_out', '>', $checkIn);
                $q->where('check_in', '<', $checkOut);
            })
            ->limit(1);
    })
    ->where('cities.name', 'like', $cityName)
    ->where('room_types.amoont', '>', $amoont)
    ->where('room_types.size', '=', $size)
    ->orderBy('room_types.price', 'desc')
    ->get();

    

    // Eloquent
    $result = Room::select('rooms.*', 'hotels.name as hotel_name', 'room_types.size as room_type_size', 'cities.name as city_name')
    ->leftJoin('hotels', 'rooms.hotel_id', '=', 'hotels.id')
    ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
    ->leftJoin('cities', 'hotels.city_id', '=', 'cities.id')
    ->whereNotExists(function ($query) use ($checkIn, $checkOut) {
        $query->select('reservations.id')
            ->from('reservations')
            ->join('reservation_room', 'reservations.id', '=', 'reservation_room.reservation_id')
            ->whereRaw('rooms.id = reservation_room.room_id')
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_out', '>', $checkIn);
                $q->where('check_in', '<', $checkOut);
            })
            ->limit(1);
    })
    ->where('cities.name', 'like', $cityName)
    ->where('room_types.amoont', '>', $amoont)
    ->where('room_types.size', '=', $size)
    ->orderBy('room_types.price', 'desc')
    ->get();

    
    
   // Eager loading version
   $result = Room::with(['hotel', 'hotel.city', 'roomType'])
   ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
   ->whereDoesntHave('reservations', function($q) use ($checkIn, $checkOut) {
       $q->where(function($q) use($checkIn, $checkOut) {
           $q->where('check_out', '>', $checkIn);
           $q->where('check_in', '<', $checkOut);
       });
   })
   ->whereHas('hotel.city', function($q) use ($cityName) {
       $q->where('name', 'like', $cityName);
   })
   ->whereHas('roomType', function($q) use ($amoont, $size) {
       $q->where('amoont', '>', $amoont);
       $q->where('size', '=', $size);
   })
   ->orderBy('room_types.price', 'asc')
   ->get();
   
   
   dump($result);

    
    // foreach ($result as $room) {
    //     echo $room->name;                    // Room name
    //     echo $room->hotel->name;             // Hotel name
    //     echo $room->roomType->size;          // Room type size
    //     echo $room->hotel->city->name;       // City name
    // }


   
    // return($result);



});
