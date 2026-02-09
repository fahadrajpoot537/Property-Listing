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
        Schema::table('contact_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('contact_submissions', 'phone_number')) {
                $table->renameColumn('phone_number', 'phone');
            } else {
                $table->string('phone')->nullable()->after('name');
            }

            $table->string('subject')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->renameColumn('phone', 'phone_number');
            $table->dropColumn('subject');
        });
    }
};
