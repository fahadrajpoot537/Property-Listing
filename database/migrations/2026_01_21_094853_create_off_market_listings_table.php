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
        Schema::create('off_market_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('property_title');
            $table->longText('description')->nullable();
            $table->string('property_reference_number')->unique();
            $table->string('purpose');
            $table->decimal('price', 15, 2);
            $table->string('area_size');
            $table->integer('bedrooms');
            $table->integer('bathrooms');

            // 🔹 Flat Specific Fields
            $table->string('tenure')->nullable();
            $table->string('unexpired_years')->nullable();
            $table->string('ground_rent')->nullable();
            $table->string('service_charge')->nullable();
            $table->string('deposit')->nullable();
            $table->string('parking_spaces_count')->nullable();
            $table->string('council_tax_band')->nullable();
            $table->string('parking_type')->nullable();
            $table->string('construction_type')->nullable();
            $table->text('rights_restrictions')->nullable();

            $table->foreignId('property_type_id')->constrained('property_types');
            $table->foreignId('unit_type_id')->constrained('unit_types');
            $table->string('ownership_status')->nullable();
            $table->string('sale_status')->nullable();
            $table->string('rent_frequency')->nullable();
            $table->string('cheque_options')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->string('video')->nullable();
            $table->string('brochure_pdf')->nullable();
            $table->string('slug')->unique();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('feature_off_market_listing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('off_market_listing_id')->constrained('off_market_listings')->cascadeOnDelete();
            $table->foreignId('feature_id')->constrained('features')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_off_market_listing');
        Schema::dropIfExists('off_market_listings');
    }
};
