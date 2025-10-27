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
        Schema::table('stp_submited_forms', function (Blueprint $table) {
            $table->integer('reminder_clicked')->default(0)->after('form_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stp_submited_forms', function (Blueprint $table) {
            $table->dropColumn('reminder_clicked');
        });
    }
};
