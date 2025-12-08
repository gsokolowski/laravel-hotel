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
        Schema::table('reservation_room', function (Blueprint $table) {
            $table->index('room_id');
            $table->index('reservation_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_room', function (Blueprint $table) {
            $table->dropIndex('reservation_room_room_id_index');
            $table->dropIndex('reservation_room_reservation_id_index');
            $table->dropIndex('reservation_room_status_index');
        });
    }
};
