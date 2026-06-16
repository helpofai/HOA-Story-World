<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Story\Models\GenreStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoryDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin/Author
        $author = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Create a regular user
        $user = User::factory()->create([
            'name' => 'Jane Reader',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);

        // Create Genres
        $genres = ['Fantasy', 'Romance', 'Horror', 'Mystery', 'Sci-Fi', 'Action', 'Adventure'];
        $genreModels = collect($genres)->map(function ($name) {
            return GenreStoryModel::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Explore our collection of $name stories.",
            ]);
        });

        // Create Stories
        $storyData = [
            [
                'title' => 'The Last Kingdom: Awakening',
                'is_featured' => true,
                'views_count' => 1500000,
                'rating' => 4.95,
            ],
            [
                'title' => 'Shadow of the Moon',
                'is_featured' => true,
                'views_count' => 850000,
                'rating' => 4.80,
            ],
            [
                'title' => 'Neon Nights: 2099',
                'is_editor_pick' => true,
                'views_count' => 120000,
                'rating' => 4.75,
            ],
            [
                'title' => 'Whispers in the Dark',
                'is_editor_pick' => true,
                'views_count' => 95000,
                'rating' => 4.60,
            ],
        ];

        foreach ($storyData as $data) {
            $story = StoryStoryModel::create(array_merge([
                'author_id' => $author->id,
                'slug' => Str::slug($data['title']),
                'subtitle' => 'A gripping tale of ' . strtolower($data['title']),
                'synopsis' => 'This is a high-level synopsis for ' . $data['title'] . '. It is designed to hook the reader immediately.',
                'status' => 'ongoing',
                'age_rating' => 'PG-13',
            ], $data));

            $story->genres()->attach($genreModels->random(2)->pluck('id'));
        }

        // Add more random stories for sections
        for ($i = 1; $i <= 20; $i++) {
            $title = "Legendary Tale $i";
            $story = StoryStoryModel::create([
                'author_id' => $author->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'synopsis' => 'A wonderful story about legends and myths.',
                'views_count' => rand(1000, 50000),
                'rating' => rand(300, 500) / 100,
                'is_editor_pick' => rand(0, 1),
            ]);
            $story->genres()->attach($genreModels->random(2)->pluck('id'));
        }
    }
}
