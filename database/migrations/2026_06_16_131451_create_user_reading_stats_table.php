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
        Schema::create('user_reading_stats', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $blueprint->integer('current_streak')->default(0);
            $blueprint->integer('max_streak')->default(0);
            $blueprint->date('last_read_date')->nullable();
            
            $blueprint->integer('total_reading_minutes')->default(0);
            $blueprint->integer('daily_reading_minutes')->default(0);
            $blueprint->integer('weekly_reading_minutes')->default(0);
            
            $blueprint->integer('chapters_read_count')->default(0);
            $blueprint->integer('stories_finished_count')->default(0);

            $blueprint->timestamps();
            
            $blueprint->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reading_stats');
    }
};
