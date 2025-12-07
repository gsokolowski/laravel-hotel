<?php

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $checkIn = '2025-12-09';
    $checkOut = '2025-12-16';
    
    // DB Query with Join
    $result = DB::table('rooms')
    ->leftJoin('hotels', 'rooms.hotel_id', '=', 'hotels.id')
    ->leftJoin('room_types','rooms.room_type_id','=','room_types.id')
    ->select('rooms.*', 'hotels.name as hotel_name', 'room_types.size as room_type_size')
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
    ->limit(10)
    ->get();

    // Eloquent ORM with Join
    $result = Room::select('rooms.*', 'hotels.name as hotel_name', 'room_types.size as room_type_size')
        ->leftJoin('hotels', 'rooms.hotel_id', '=', 'hotels.id')
        ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
        ->whereDoesntHave('reservations', function($q) use ($checkIn, $checkOut) {
            $q->where(function($q) use($checkIn, $checkOut) {
                $q->where('check_out', '>', $checkIn);
                $q->where('check_in', '<', $checkOut);
            });
        })
        ->limit(10)
        ->get();

    // The same (similar query) using eager loading here you will have all fields from hotel and roomType models
    $result = Room::with(['hotel', 'roomType'])
    ->whereDoesntHave('reservations' , function($q) use ($checkIn, $checkOut) {
                $q->where(function($q) use($checkIn, $checkOut) {
                    $q->where('check_out', '>', $checkIn);
                    $q->where('check_in', '<', $checkOut);
            });
        })
        ->limit(10)
        ->get();

    // return($result);

    dump($result);

});
