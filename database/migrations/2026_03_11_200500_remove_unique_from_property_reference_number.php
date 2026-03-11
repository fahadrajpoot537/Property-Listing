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
        Schema::table('listings', function (Blueprint $table) {
            $table->dropUnique(['property_reference_number']);
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->dropUnique(['property_reference_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->unique('property_reference_number');
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->unique('property_reference_number');
        });
    }
};
