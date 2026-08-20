<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stp_schools', function (Blueprint $table) {
            $table->unique(['school_countryCode', 'school_contactNo'], 'stp_schools_countrycode_contactno_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stp_schools', function (Blueprint $table) {
            $table->dropUnique('stp_schools_countrycode_contactno_unique');
        });
    }
};
