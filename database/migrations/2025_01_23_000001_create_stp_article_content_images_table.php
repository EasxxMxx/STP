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
        Schema::create('stp_article_content_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained('stp_article')->onDelete('cascade');
            $table->string('image_path');
            $table->integer('image_order')->default(0)->comment('Order of image in the article');
            $table->string('image_alt')->nullable()->comment('Alt text for image');
            $table->integer('data_status')->default(1)->comment('1 = Active, 0 = Disable');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            
            $table->index('article_id');
            $table->index('data_status');
            $table->index('image_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stp_article_content_images');
    }
};

