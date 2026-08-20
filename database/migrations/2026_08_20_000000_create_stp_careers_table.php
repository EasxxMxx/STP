<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stp_careers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->unsignedTinyInteger('realistic');
            $table->unsignedTinyInteger('investigative');
            $table->unsignedTinyInteger('artistic');
            $table->unsignedTinyInteger('social');
            $table->unsignedTinyInteger('enterprising');
            $table->unsignedTinyInteger('conventional');
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stp_careers');
    }
};
