<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('synopsis');
            $table->string('cover_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->enum('status', ['ongoing', 'completed', 'hiatus', 'dropped'])->default('ongoing');
            $table->enum('age_rating', ['G', 'PG', 'PG-13', 'R', 'NC-17'])->default('G');
            
            // Statistics
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('readers_count')->default(0);
            $table->unsignedBigInteger('followers_count')->default(0);
            $table->unsignedBigInteger('favorites_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_editor_pick')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
