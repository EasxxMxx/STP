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
        Schema::create('stp_article_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained('stp_article')->onDelete('set null');
            $table->integer('totalNumberVisit')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stp_article_visits');
    }
};

