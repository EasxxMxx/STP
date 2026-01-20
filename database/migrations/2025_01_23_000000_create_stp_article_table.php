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
        Schema::create('stp_article', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('stp_article_category')->onDelete('set null');
            $table->string('article_title');
            $table->string('article_author');
            $table->date('article_date');
            $table->integer('article_featured')->default(0)->comment('0 = No, 1 = Yes');
            $table->integer('article_views')->default(0);
            $table->string('article_featured_image')->nullable();
            $table->text('article_summary')->nullable();
            $table->string('article_main_points_1')->nullable();
            $table->string('article_main_points_2')->nullable();
            $table->string('article_main_points_3')->nullable();
            $table->string('article_content')->nullable()->comment('Path to HTML file containing article content');
            $table->integer('data_status')->default(1)->comment('1 = Active, 0 = Disable');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            
            $table->index('category_id');
            $table->index('data_status');
            $table->index('article_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stp_article');
    }
};

