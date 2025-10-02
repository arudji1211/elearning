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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('image_id')->nullable();
            $table->text('description');
            $table->uuid('level_id');
            $table->uuid('course_id');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('image_id')->references('id')->on('images')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
