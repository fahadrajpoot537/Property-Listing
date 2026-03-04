<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        $tables = ['listings', 'off_market_listings'];

        foreach ($tables as $tbl) {

            Schema::table($tbl, function (Blueprint $table) use ($tbl) {

                if (!Schema::hasColumn($tbl, 'council_tax_band')) {
                    $table->string('council_tax_band')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'epc_rating')) {
                    $table->string('epc_rating')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'floors_count')) {
                    $table->integer('floors_count')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'availability_date')) {
                    $table->date('availability_date')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'no_onward_chain')) {
                    $table->boolean('no_onward_chain')->default(false);
                }

                if (!Schema::hasColumn($tbl, 'private_rights_of_way')) {
                    $table->text('private_rights_of_way')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'public_rights_of_way')) {
                    $table->text('public_rights_of_way')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'listed_property')) {
                    $table->string('listed_property')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'restrictions')) {
                    $table->text('restrictions')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'flood_risk')) {
                    $table->string('flood_risk')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'flood_history')) {
                    $table->text('flood_history')->nullable();
                }

                if (!Schema::hasColumn($tbl, 'flood_defenses')) {
                    $table->text('flood_defenses')->nullable();
                }

            });
        }
    }

    public function down(): void
    {
        $tables = ['listings', 'off_market_listings'];

        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
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