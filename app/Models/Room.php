<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    // room belongs to many reservations
    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }
}
