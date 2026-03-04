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
        $tables = ['listings', 'off_market_listings'];

        foreach ($tables as $baseTable) {
            Schema::table($baseTable, function (Blueprint $table) {
                // Step 1: Mandatory Fields (Ensure they exist)
                if (!Schema::hasColumn($table->getTable(), 'postcode'))
                    $table->string('postcode')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'display_address'))
                    $table->string('display_address')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'price_qualifier'))
                    $table->string('price_qualifier')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'rent_frequency'))
                    $table->string('rent_frequency')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'sub_type'))
                    $table->string('sub_type')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'summary_description'))
                    $table->string('summary_description', 300)->nullable();

                // Add missing fields for Step 2/3 if not already in base table
                if (!Schema::hasColumn($table->getTable(), 'reception_rooms'))
                    $table->integer('reception_rooms')->default(0);
                if (!Schema::hasColumn($table->getTable(), 'floor_level'))
                    $table->string('floor_level')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'epc_upload'))
                    $table->string('epc_upload')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'virtual_tour_url'))
                    $table->text('virtual_tour_url')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'tags'))
                    $table->json('tags')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'government_scheme'))
                    $table->string('government_scheme')->nullable();
                if (!Schema::hasColumn($table->getTable(), 'deposit'))
                    $table->decimal('deposit', 15, 2)->nullable();
            });

            $prefix = ($baseTable === 'listings') ? 'listing' : 'off_market';

            // 1. Material Info Table
            Schema::create("{$prefix}_material_info", function (Blueprint $table) use ($baseTable) {
                $table->id();
                $table->foreignId("{$baseTable}_id")->constrained($baseTable)->cascadeOnDelete();
                $table->string('tenure')->nullable();
                $table->string('unexpired_years')->nullable();
                $table->decimal('ground_rent', 15, 2)->nullable();
                $table->decimal('service_charge', 15, 2)->nullable();
                $table->string('council_tax_band')->nullable();
                $table->string('parking_type')->nullable();
                $table->integer('parking_spaces_count')->default(0);
                $table->string('construction_type')->nullable();
                $table->text('accessibility')->nullable();
                $table->text('rights_restrictions')->nullable();
                $table->string('listed_building')->nullable();
                $table->string('flood_risk')->nullable();
                $table->string('cladding_risk')->nullable();
                $table->text('other_risks')->nullable();
                $table->timestamps();
            });

            // 2. Utilities Table
            Schema::create("{$prefix}_utilities", function (Blueprint $table) use ($baseTable) {
                $table->id();
                $table->foreignId("{$baseTable}_id")->constrained($baseTable)->cascadeOnDelete();
                $table->string('water')->nullable();
                $table->string('electricity')->nullable();
                $table->string('sewerage')->nullable();
                $table->string('heating_type')->nullable();
                $table->string('broadband')->nullable();
                $table->string('mobile_coverage')->nullable();
                $table->timestamps();
            });

            // 3. Media Table
            Schema::create("{$prefix}_media", function (Blueprint $table) use ($baseTable) {
                $table->id();
                $table->foreignId("{$baseTable}_id")->constrained($baseTable)->cascadeOnDelete();
                $table->string('type'); // photo, floorplan, epc, brochure, video
                $table->string('file_path');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });

            // 4. Rooms Table
            Schema::create("{$prefix}_rooms", function (Blueprint $table) use ($baseTable) {
                $table->id();
                $table->foreignId("{$baseTable}_id")->constrained($baseTable)->cascadeOnDelete();
                $table->string('room_name')->nullable();
                $table->string('room_size')->nullable();
                $table->text('room_description')->nullable();
                $table->timestamps();
            });

            // 5. Details Table (Optional but suggested by user)
            Schema::create("{$prefix}_details", function (Blueprint $table) use ($baseTable) {
                $table->id();
                $table->foreignId("{$baseTable}_id")->constrained($baseTable)->cascadeOnDelete();
                $table->json('key_features')->nullable();
                $table->json('tags')->nullable();
                $table->string('government_scheme')->nullable();
                $table->decimal('deposit', 15, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['listings', 'off_market_listings'];

        foreach ($tables as $baseTable) {
            $prefix = ($baseTable === 'listings') ? 'listing' : 'off_market';
            Schema::dropIfExists("{$prefix}_details");
            Schema::dropIfExists("{$prefix}_rooms");
            Schema::dropIfExists("{$prefix}_media");
            Schema::dropIfExists("{$prefix}_utilities");
            Schema::dropIfExists("{$prefix}_material_info");
        }
    }
};
