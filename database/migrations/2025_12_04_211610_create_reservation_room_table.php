<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservation_room', function (Blueprint $table) {
            $table->id();
            // Foreign key to reservations table
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            // Foreign key to rooms table
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->boolean('status')->default(false);
            // Prevent duplicate room assignments for the same reservation
            $table->unique(['reservation_id', 'room_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_room');
    }
};
