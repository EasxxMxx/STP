<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stp_mascot_guides', function (Blueprint $table) {
            $table->id();
            $table->string('guide_key')->unique();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_path')->nullable();
            $table->json('page_patterns')->nullable();
            $table->string('path_param_pattern')->nullable();
            $table->string('trigger_type')->nullable();
            $table->unsignedInteger('trigger_delay_ms')->nullable();
            $table->unsignedInteger('trigger_threshold')->nullable();
            $table->string('anchor_target')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('priority')->default(0)->index();
            $table->string('dismiss_scope')->default('session');
            $table->string('visit_condition')->default('any');
            $table->string('publication_status')->default('draft')->index();
            $table->unsignedTinyInteger('data_status')->default(1)->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stp_mascot_guides');
    }
};
