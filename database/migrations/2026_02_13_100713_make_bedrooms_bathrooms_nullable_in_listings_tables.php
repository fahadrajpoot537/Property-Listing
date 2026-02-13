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
            $table->integer('bedrooms')->nullable()->change();
            $table->integer('bathrooms')->nullable()->change();
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->change();
            $table->integer('bathrooms')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable(false)->change();
            $table->integer('bathrooms')->nullable(false)->change();
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable(false)->change();
            $table->integer('bathrooms')->nullable(false)->change();
        });
    }
};
