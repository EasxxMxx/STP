<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('stp_mascot_guides', 'visit_condition')) {
            Schema::table('stp_mascot_guides', function (Blueprint $table) {
                $table->string('visit_condition')->default('any')->after('dismiss_scope');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('stp_mascot_guides', 'visit_condition')) {
            Schema::table('stp_mascot_guides', function (Blueprint $table) {
                $table->dropColumn('visit_condition');
            });
        }
    }
};
