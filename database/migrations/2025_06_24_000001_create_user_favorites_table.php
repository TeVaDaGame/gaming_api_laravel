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
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['favorite', 'wishlist'])->default('favorite');
            $table->text('notes')->nullable(); // Optional personal notes
            $table->timestamps();
            
            // Ensure a user can't favorite the same game twice with the same type
            $table->unique(['user_id', 'game_id', 'type']);
            
            // Add indexes for better performance
            $table->index(['user_id', 'type']);
            $table->index(['game_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favorites');
    }
};
