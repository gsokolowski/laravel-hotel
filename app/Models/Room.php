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


    protected $guarded = []; // allow all fields to be mass assigned

    protected $fillable = ['name', 'hotel_id', 'room_type_id'];
    protected $hidden = ['created_at', 'updated_at'];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['room_type_name'];

    public function getRoomTypeNameAttribute()
    {
        return $this->roomType->name;
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    // room belongs to many reservations through pivot table reservations_rooms
    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }
}
