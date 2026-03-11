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
            $table->dropForeign(['unit_type_id']);
            $table->dropColumn('unit_type_id');
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->dropForeign(['unit_type_id']);
            $table->dropColumn('unit_type_id');
        });

        Schema::dropIfExists('unit_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('property_type_id')->constrained('property_types');
            $table->timestamps();
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('unit_type_id')->nullable()->constrained('unit_types');
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->foreignId('unit_type_id')->nullable()->constrained('unit_types');
        });
    }
};
