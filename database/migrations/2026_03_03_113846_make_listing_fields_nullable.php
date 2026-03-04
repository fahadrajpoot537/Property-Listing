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
        // 1. Listings Table Adjustments
        Schema::table('listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->change();
            $table->integer('bathrooms')->nullable()->change();
            $table->integer('reception_rooms')->nullable()->change();
            $table->string('postcode')->nullable()->change();
            $table->string('address', 500)->nullable()->change();
            $table->string('display_address')->nullable()->change();
            $table->string('summary_description', 300)->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('price_qualifier')->nullable()->change();
            $table->foreignId('property_type_id')->nullable()->change();
            $table->foreignId('unit_type_id')->nullable()->change();
        });

        // 2. Off Market Listings Table Adjustments
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->change();
            $table->integer('bathrooms')->nullable()->change();
            $table->integer('reception_rooms')->nullable()->change();
            $table->string('postcode')->nullable()->change();
            $table->string('address', 500)->nullable()->change();
            $table->string('display_address')->nullable()->change();
            $table->string('summary_description', 300)->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('price_qualifier')->nullable()->change();
            $table->foreignId('property_type_id')->nullable()->change();
            $table->foreignId('unit_type_id')->nullable()->change();
        });

        // 3. Material Info Table Adjustments
        Schema::table('listing_material_info', function (Blueprint $table) {
            $table->integer('parking_spaces_count')->nullable()->change();
        });

        Schema::table('off_market_material_info', function (Blueprint $table) {
            $table->integer('parking_spaces_count')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as making fields nullable is safe and intended for stability
    }
};
