<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    // Delete all reservations from reservation_room table in chunks of 5 where status is 0
    // This works
    Reservation::chunk(5, function ($reservations) {
        foreach ($reservations as $reservation) {
            // Get room IDs where status = 0 in the pivot table
            $roomIds = $reservation->rooms()
                ->wherePivot('status', 0)
                ->pluck('rooms.id')
                ->toArray();
            
            // Detach those rooms (delete from pivot table)
            if (!empty($roomIds)) {
                $reservation->rooms()->detach($roomIds);
            }
        }
    });

    // Delete all reservations from reservation_room table where status is 0 (one go)
    $reservations = Reservation::all();
    // This works
    foreach ($reservations as $reservation) {
        // Get room IDs where status = 0 in the pivot table
        $roomIds = $reservation->rooms()
            ->wherePivot('status', 0)
            ->pluck('rooms.id')
            ->toArray();
        
        // Detach those rooms (delete from pivot table)
        if (!empty($roomIds)) {
            $reservation->rooms()->detach($roomIds);
        }
    }


    // dump($result);    
    // return response()->json($result);
});
