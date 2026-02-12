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

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('council_tax_band')->nullable();
                $table->string('epc_rating')->nullable();
                $table->integer('floors_count')->nullable();
                $table->date('availability_date')->nullable();
                $table->boolean('no_onward_chain')->default(false);
                $table->text('private_rights_of_way')->nullable();
                $table->text('public_rights_of_way')->nullable();
                $table->string('listed_property')->nullable();
                $table->text('restrictions')->nullable();
                $table->string('flood_risk')->nullable();
                $table->text('flood_history')->nullable();
                $table->text('flood_defenses')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['listings', 'off_market_listings'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn([
                    'council_tax_band',
                    'epc_rating',
                    'floors_count',
                    'availability_date',
                    'no_onward_chain',
                    'private_rights_of_way',
                    'public_rights_of_way',
                    'listed_property',
                    'restrictions',
                    'flood_risk',
                    'flood_history',
                    'flood_defenses',
                ]);
            });
        }
    }
};
