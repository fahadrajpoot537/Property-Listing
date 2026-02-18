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
        Schema::create('trustpilot_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('rating'); // To store the stars rating (e.g., '5.0', '4.5')
            $table->string('review_count'); // To store the number of reviews (e.g., '1,234 Reviews' or just '1234')
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trustpilot_reviews');
    }
};
