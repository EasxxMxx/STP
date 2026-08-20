<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stp_personality_test_results', function (Blueprint $table) {
            $table->json('career_matches')->nullable()->after('score');
            $table->unsignedInteger('career_match_version')->nullable()->after('career_matches');
        });
    }

    public function down(): void
    {
        Schema::table('stp_personality_test_results', function (Blueprint $table) {
            $table->dropColumn(['career_matches', 'career_match_version']);
        });
    }
};
