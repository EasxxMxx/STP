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
        Schema::create('stp_article_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('color_code', 50);
            $table->text('description')->nullable();
            $table->integer('data_status')->default(1)->comment('1 = Active, 0 = Disable');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            
            $table->index('data_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stp_article_category');
    }
};

