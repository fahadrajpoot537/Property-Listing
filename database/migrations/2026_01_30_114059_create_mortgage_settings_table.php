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
        Schema::create('mortgage_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('down_payment_percentage', 5, 2)->default(20.00); // e.g. 20.00%
            $table->decimal('interest_rate', 5, 2)->default(3.50); // e.g. 3.50%
            $table->integer('loan_term_years')->default(20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_settings');
    }
};
