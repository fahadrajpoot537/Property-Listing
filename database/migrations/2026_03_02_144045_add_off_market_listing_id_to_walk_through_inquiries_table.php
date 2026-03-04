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
        Schema::table('walk_through_inquiries', function (Blueprint $table) {
            $table->foreignId('listing_id')->nullable()->change();
            $table->foreignId('off_market_listing_id')->nullable()->after('listing_id')->constrained('off_market_listings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('walk_through_inquiries', function (Blueprint $table) {
            $table->dropForeign(['off_market_listing_id']);
            $table->dropColumn('off_market_listing_id');
            $table->foreignId('listing_id')->nullable(false)->change();
        });
    }
};
