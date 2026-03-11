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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Pivot tables for listings
        Schema::create('amenity_listing', function (Blueprint $table) {
            $table->foreignId('amenity_id')->constrained()->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
        });

        Schema::create('listing_tag', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
        });

        // Pivot tables for off_market_listings
        Schema::create('amenity_off_market_listing', function (Blueprint $table) {
            $table->foreignId('amenity_id')->constrained()->onDelete('cascade');
            $table->foreignId('off_market_listing_id')->constrained('off_market_listings')->onDelete('cascade');
        });

        Schema::create('off_market_listing_tag', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->foreignId('off_market_listing_id')->constrained('off_market_listings')->onDelete('cascade');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn(['display_address', 'postcode', 'summary_description']);
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->dropColumn(['display_address', 'postcode', 'summary_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('display_address')->nullable();
            $table->string('postcode')->nullable();
            $table->text('summary_description')->nullable();
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->string('display_address')->nullable();
            $table->string('postcode')->nullable();
            $table->text('summary_description')->nullable();
        });

        Schema::dropIfExists('off_market_listing_tag');
        Schema::dropIfExists('amenity_off_market_listing');
        Schema::dropIfExists('listing_tag');
        Schema::dropIfExists('amenity_listing');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('amenities');
    }
};
