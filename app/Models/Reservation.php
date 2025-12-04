<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    // Reservation belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // reservation belongs to many rooms through pivot table reservations_rooms
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }
}
