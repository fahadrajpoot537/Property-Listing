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
        Schema::table('affiliates', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('referral_code');
            $table->string('promotion_method')->nullable()->after('whatsapp_number');
            $table->string('website_url')->nullable()->after('promotion_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'promotion_method', 'website_url']);
        });
    }
};
