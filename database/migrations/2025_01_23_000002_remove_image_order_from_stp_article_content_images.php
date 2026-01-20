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
        Schema::table('stp_article_content_images', function (Blueprint $table) {
            // Drop index if it exists (using raw SQL for custom index name)
            \DB::statement('DROP INDEX IF EXISTS idx_image_order ON stp_article_content_images');
            // Drop the column (Laravel will also try to drop auto-generated indexes)
            $table->dropColumn('image_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stp_article_content_images', function (Blueprint $table) {
            // Re-add the column
            $table->integer('image_order')->default(0)->comment('Order of image in the article')->after('image_path');
            // Re-add the index
            $table->index('image_order');
        });
    }
};

