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
        Schema::create('favorite_words', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('word_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_words');
    }
};
