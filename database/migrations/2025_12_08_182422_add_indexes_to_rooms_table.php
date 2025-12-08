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
        Schema::table('rooms', function (Blueprint $table) {
            // Index on name if you search/filter by room name
            $table->index('name');
            
            // Composite index for common query patterns
            // If you frequently query by hotel_id and room_type_id together
            $table->index(['hotel_id', 'room_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['hotel_id', 'room_type_id']);
        });
    }
};
