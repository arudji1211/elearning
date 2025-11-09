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
        Schema::create('game_session_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('game_session_id');
            $table->uuid('question_id');
            $table->uuid('answer_id')->nullable();
            $table->string('result')->nullable();
            $table->timestamps();

            $table->foreign('game_session_id')->references('id')->on('game_sessions')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_session_activities');
    }
};
