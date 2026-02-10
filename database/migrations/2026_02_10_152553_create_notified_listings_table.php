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
        Schema::create('notified_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_inquiry_id');
            $table->unsignedBigInteger('listing_id');
            $table->timestamps();

            $table->foreign('property_inquiry_id')->references('id')->on('property_inquiries')->onDelete('cascade');
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->unique(['property_inquiry_id', 'listing_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notified_listings');
    }
};
