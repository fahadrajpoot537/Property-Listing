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
        // Change bedrooms to string in main tables
        Schema::table('listings', function (Blueprint $table) {
            $table->string('bedrooms')->nullable()->change();
        });
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->string('bedrooms')->nullable()->change();
        });

        // Change financial fields in material info tables
        Schema::table('listing_material_info', function (Blueprint $table) {
            $table->string('ground_rent')->nullable()->change();
            $table->string('service_charge')->nullable()->change();
        });
        Schema::table('off_market_material_info', function (Blueprint $table) {
            $table->string('ground_rent')->nullable()->change();
            $table->string('service_charge')->nullable()->change();
        });

        // Change deposit in details and main tables
        Schema::table('listings', function (Blueprint $table) {
            $table->string('deposit')->nullable()->change();
        });
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->string('deposit')->nullable()->change();
        });
        Schema::table('listing_details', function (Blueprint $table) {
            $table->string('deposit')->nullable()->change();
        });
        Schema::table('off_market_details', function (Blueprint $table) {
            $table->string('deposit')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback is harder since we lose decimal precision/type info,
        // but we can set them back to types they were before.
        Schema::table('listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->change();
            $table->decimal('deposit', 15, 2)->nullable()->change();
        });
        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->change();
            $table->decimal('deposit', 15, 2)->nullable()->change();
        });

        Schema::table('listing_material_info', function (Blueprint $table) {
            $table->decimal('ground_rent', 15, 2)->nullable()->change();
            $table->decimal('service_charge', 15, 2)->nullable()->change();
        });
        Schema::table('off_market_material_info', function (Blueprint $table) {
            $table->decimal('ground_rent', 15, 2)->nullable()->change();
            $table->decimal('service_charge', 15, 2)->nullable()->change();
        });

        Schema::table('listing_details', function (Blueprint $table) {
            $table->decimal('deposit', 15, 2)->nullable()->change();
        });
        Schema::table('off_market_details', function (Blueprint $table) {
            $table->decimal('deposit', 15, 2)->nullable()->change();
        });
    }
};
