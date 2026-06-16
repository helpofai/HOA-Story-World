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
        Schema::create('story_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->default('city'); // kingdom, city, village, dungeon, landmark
            
            // Percentage coordinates for responsiveness (0-100)
            $table->decimal('x_pos', 5, 2);
            $table->decimal('y_pos', 5, 2);
            
            $table->string('icon')->nullable();
            $table->boolean('is_secret')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_locations');
    }
};
