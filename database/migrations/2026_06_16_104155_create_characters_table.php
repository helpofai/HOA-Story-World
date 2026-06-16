<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            $table->string('name');
            $table->string('initials', 2)->nullable();
            $table->string('role')->nullable(); // Protagonist, Antagonist, etc.
            $table->integer('age')->nullable();
            $table->text('description')->nullable();
            $table->string('color_theme')->default('blue'); // UI theme color
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};