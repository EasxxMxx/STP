<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stp_career_asset_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained('stp_careers')->cascadeOnDelete();
            $table->string('left_source_path')->nullable();
            $table->string('left_image_path')->nullable();
            $table->string('center_source_path')->nullable();
            $table->string('center_image_path')->nullable();
            $table->string('right_source_path')->nullable();
            $table->string('right_image_path')->nullable();
            $table->string('status', 16)->default('draft')->index();
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['career_id', 'status']);
        });

        Schema::create('stp_riasec_poster_asset_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('riasec_type_id');
            $table->string('animal_name')->nullable();
            $table->string('animal_source_path')->nullable();
            $table->string('animal_image_path')->nullable();
            $table->json('traits');
            $table->string('accent_color', 7)->default('#c71919');
            $table->string('status', 16)->default('draft')->index();
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['riasec_type_id', 'status'], 'riasec_poster_type_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stp_riasec_poster_asset_sets');
        Schema::dropIfExists('stp_career_asset_sets');
    }
};
