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
            $table->foreignId('ownership_status_id')->nullable()->constrained();
            $table->foreignId('rent_frequency_id')->nullable()->constrained();
            $table->foreignId('cheque_id')->nullable()->constrained();
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->foreignId('ownership_status_id')->nullable()->constrained();
            $table->foreignId('rent_frequency_id')->nullable()->constrained();
            $table->foreignId('cheque_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['ownership_status_id']);
            $table->dropForeign(['rent_frequency_id']);
            $table->dropForeign(['cheque_id']);
            $table->dropColumn(['ownership_status_id', 'rent_frequency_id', 'cheque_id']);
        });

        Schema::table('off_market_listings', function (Blueprint $table) {
            $table->dropForeign(['ownership_status_id']);
            $table->dropForeign(['rent_frequency_id']);
            $table->dropForeign(['cheque_id']);
            $table->dropColumn(['ownership_status_id', 'rent_frequency_id', 'cheque_id']);
        });
    }
};
