<?php

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $checkIn = '2025-12-09';
    $checkOut = '2025-12-16';
    
    // Get all rooms that don't have overlapping reservations
    // select * from `rooms` where not exists (select * from `reservations` inner join `reservation_room` on `reservations`.`id` = `reservation_room`.`reservation_id` where `rooms`.`id` = `reservation_room`.`room_id` and (`check_in` < '2025-12-16' and `check_out` > '2025-12-09'))
    $availableRooms = Room::whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut) {
        $query->where(function ($q) use ($checkIn, $checkOut) {
            // Check for date overlap: reservation overlaps if:
            // reservation.check_in < requested.check_out AND reservation.check_out > requested.check_in
            $q->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });
    })->get();
    
    // Get all rooms that have overlapping reservations
    // select * from `rooms` where exists (select * from `reservations` inner join `reservation_room` on `reservations`.`id` = `reservation_room`.`reservation_id` where `rooms`.`id` = `reservation_room`.`room_id` and (`check_in` < '2025-12-16' and `check_out` > '2025-12-09'))
    $notAvailableRooms = Room::whereHas('reservations', function ($query) use ($checkIn, $checkOut) {
        $query->where(function ($q) use ($checkIn, $checkOut) {
            // Check for date overlap: reservation overlaps if:
            // reservation.check_in < requested.check_out AND reservation.check_out > requested.check_in
            $q->where('check_in', '<', $checkOut)
                ->where('check_out', '>', $checkIn);
        });
    })->get();

    //  return [
    //     'available' => $availableRooms,
    //     'not_available' => $notAvailableRooms
    // ];

    // return response()->json([
    //     'status' => 'success',
    //     'message' => 'Rooms retrieved successfully',
    //     'data' => [
    //         'available' => $availableRooms,
    //         'not_available' => $notAvailableRooms
    //     ],
    //     'counts' => [
    //         'available_count' => $availableRooms->count(),
    //         'not_available_count' => $notAvailableRooms->count()
    //     ]
    // ]);

    // Get all reservations with the minimum price
    // select * from `reservations` where `price` = (select MIN(price) from `reservations`)
    $reservations = Reservation::where('price', function($query) {
        $query->selectRaw('MIN(price)')
            ->from('reservations');
    })->get();

    // Get the minimum price
    // select min(`price`) as aggregate from `reservations`
    $minPrice = Reservation::min('price');

    // Get all reservations with that minimum price
    // select * from `reservations` where `price` = '56.57'
    $reservations = Reservation::where('price', $minPrice)->get();

    //return($reservations);

    dump($reservations);

});
