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
            if (!Schema::hasColumn('listings', 'tenure')) {
                $table->string('tenure')->nullable();
            }
            if (!Schema::hasColumn('listings', 'unexpired_years')) {
                $table->string('unexpired_years')->nullable();
            }
            if (!Schema::hasColumn('listings', 'ground_rent')) {
                $table->string('ground_rent')->nullable();
            }
            if (!Schema::hasColumn('listings', 'service_charge')) {
                $table->string('service_charge')->nullable();
            }
            if (!Schema::hasColumn('listings', 'deposit')) {
                $table->string('deposit')->nullable();
            }
            if (!Schema::hasColumn('listings', 'parking_spaces_count')) {
                $table->string('parking_spaces_count')->nullable();
            }
            if (!Schema::hasColumn('listings', 'council_tax_band')) {
                $table->string('council_tax_band')->nullable();
            }
            if (!Schema::hasColumn('listings', 'parking_type')) {
                $table->string('parking_type')->nullable();
            }
            if (!Schema::hasColumn('listings', 'construction_type')) {
                $table->string('construction_type')->nullable();
            }
            if (!Schema::hasColumn('listings', 'accessibility')) {
                $table->text('accessibility')->nullable();
            }
            if (!Schema::hasColumn('listings', 'rights_restrictions')) {
                $table->text('rights_restrictions')->nullable();
            }
            if (!Schema::hasColumn('listings', 'listed_building')) {
                $table->string('listed_building')->nullable();
            }
            if (!Schema::hasColumn('listings', 'flood_risk')) {
                $table->string('flood_risk')->nullable();
            }
            if (!Schema::hasColumn('listings', 'cladding_risk')) {
                $table->string('cladding_risk')->nullable();
            }
            if (!Schema::hasColumn('listings', 'utilities_water')) {
                $table->string('utilities_water')->nullable();
            }
            if (!Schema::hasColumn('listings', 'utilities_electricity')) {
                $table->string('utilities_electricity')->nullable();
            }
            if (!Schema::hasColumn('listings', 'utilities_sewerage')) {
                $table->string('utilities_sewerage')->nullable();
            }
            if (!Schema::hasColumn('listings', 'heating_type')) {
                $table->string('heating_type')->nullable();
            }
            if (!Schema::hasColumn('listings', 'broadband')) {
                $table->string('broadband')->nullable();
            }
            if (!Schema::hasColumn('listings', 'mobile_coverage')) {
                $table->string('mobile_coverage')->nullable();
            }
            if (!Schema::hasColumn('listings', 'key_features')) {
                $table->json('key_features')->nullable();
            }
            if (!Schema::hasColumn('listings', 'tags')) {
                $table->json('tags')->nullable();
            }
            if (!Schema::hasColumn('listings', 'government_scheme')) {
                $table->string('government_scheme')->nullable();
            }
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            if (!Schema::hasColumn('off_market_listings', 'tenure')) {
                $table->string('tenure')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'unexpired_years')) {
                $table->string('unexpired_years')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'ground_rent')) {
                $table->string('ground_rent')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'service_charge')) {
                $table->string('service_charge')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'deposit')) {
                $table->string('deposit')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'parking_spaces_count')) {
                $table->string('parking_spaces_count')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'council_tax_band')) {
                $table->string('council_tax_band')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'parking_type')) {
                $table->string('parking_type')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'construction_type')) {
                $table->string('construction_type')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'accessibility')) {
                $table->text('accessibility')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'rights_restrictions')) {
                $table->text('rights_restrictions')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'listed_building')) {
                $table->string('listed_building')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'flood_risk')) {
                $table->string('flood_risk')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'cladding_risk')) {
                $table->string('cladding_risk')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'utilities_water')) {
                $table->string('utilities_water')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'utilities_electricity')) {
                $table->string('utilities_electricity')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'utilities_sewerage')) {
                $table->string('utilities_sewerage')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'heating_type')) {
                $table->string('heating_type')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'broadband')) {
                $table->string('broadband')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'mobile_coverage')) {
                $table->string('mobile_coverage')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'key_features')) {
                $table->json('key_features')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'tags')) {
                $table->json('tags')->nullable();
            }
            if (!Schema::hasColumn('off_market_listings', 'government_scheme')) {
                $table->string('government_scheme')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->decimal('ground_rent', 15, 2)->nullable()->change();
            $table->decimal('service_charge', 15, 2)->nullable()->change();
            $table->decimal('deposit', 15, 2)->nullable()->change();
            $table->integer('parking_spaces_count')->default(0)->change();
            $table->integer('unexpired_years')->nullable()->change();
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->decimal('ground_rent', 15, 2)->nullable()->change();
            $table->decimal('service_charge', 15, 2)->nullable()->change();
            $table->decimal('deposit', 15, 2)->nullable()->change();
            $table->integer('parking_spaces_count')->default(0)->change();
            $table->integer('unexpired_years')->nullable()->change();
        });
    }
};