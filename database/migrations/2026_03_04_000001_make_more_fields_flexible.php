<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change bathrooms and reception_rooms in main tables for flexibility (e.g. "11+", "Ask agent")
        Schema::table('listings', function (Blueprint $table) {
            $table->string('bathrooms')->nullable()->change();
            $table->string('reception_rooms')->nullable()->change();
        });
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->string('bathrooms')->nullable()->change();
            $table->string('reception_rooms')->nullable()->change();
        });

        // Change parking_spaces_count in material info tables
        Schema::table('listing_material_info', function (Blueprint $table) {
            $table->string('parking_spaces_count')->nullable()->change();
        });
        Schema::table('off_market_material_info', function (Blueprint $table) {
            $table->string('parking_spaces_count')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->integer('bathrooms')->nullable()->change();
            $table->integer('reception_rooms')->nullable()->change();
        });
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->integer('bathrooms')->nullable()->change();
            $table->integer('reception_rooms')->nullable()->change();
        });

        Schema::table('listing_material_info', function (Blueprint $table) {
            $table->integer('parking_spaces_count')->nullable()->change();
        });
        Schema::table('off_market_material_info', function (Blueprint $table) {
            $table->integer('parking_spaces_count')->nullable()->change();
        });
    }
};
