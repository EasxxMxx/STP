<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stp_article', function (Blueprint $table) {
            $table->json('article_intent_config')->nullable()->after('article_content');
        });
    }

    public function down(): void
    {
        Schema::table('stp_article', function (Blueprint $table) {
            $table->dropColumn('article_intent_config');
        });
    }
};
