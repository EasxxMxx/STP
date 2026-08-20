<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stp_personality_test_results', function (Blueprint $table) {
            $table->string('share_token', 64)->nullable()->unique()->after('status');
            $table->timestamp('shared_at')->nullable()->after('share_token');
        });
    }

    public function down(): void
    {
        Schema::table('stp_personality_test_results', function (Blueprint $table) {
            $table->dropUnique(['share_token']);
            $table->dropColumn(['share_token', 'shared_at']);
        });
    }
};
