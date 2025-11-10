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
        Schema::table('stp_free_education', function (Blueprint $table) {
            if (!Schema::hasColumn('stp_free_education', 'data_status')) {
                $table->integer('data_status')->default(1)->after('background_color_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stp_free_education', function (Blueprint $table) {
            if (Schema::hasColumn('stp_free_education', 'data_status')) {
                $table->dropColumn('data_status');
            }
        });
    }
};
