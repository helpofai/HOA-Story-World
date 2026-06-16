<?php

namespace App\Modules\Author\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\GenreStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoryCreatorViewController extends Controller
{
    public function create()
    {
        $genres = GenreStoryModel::all();
        
        return view('modules.author.create_story', [
            'genres' => $genres,
            'ageRatings' => ['G', 'PG', 'PG-13', 'R', 'NC-17'],
            'statuses' => ['ongoing', 'completed', 'hiatus', 'dropped']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'synopsis' => 'required|string',
            'language' => 'required|string|max:10',
            'age_rating' => 'required|string',
            'status' => 'required|string',
            'genres' => 'required|array|min:1',
            'cover_image' => 'nullable|image|max:5120', // Increased to 5MB
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                $story = StoryStoryModel::create([
                    'author_id' => Auth::id(),
                    'title' => $validated['title'],
                    'slug' => Str::slug($validated['title']) . '-' . uniqid(),
                    'subtitle' => $validated['subtitle'],
                    'synopsis' => $validated['synopsis'],
                    'language' => $validated['language'],
                    'age_rating' => $validated['age_rating'],
                    'status' => $validated['status'],
                ]);

                if ($request->has('genres')) {
                    $story->genres()->attach($request->genres);
                }

                // Create the first chapter immediately for a "Start Writing" experience
                $chapter = $story->chapters()->create([
                    'title' => 'Chapter 1: The Beginning',
                    'content' => '<p>Once upon a time...</p>',
                    'order_index' => 1,
                    'status' => 'draft'
                ]);

                // Handle Image Upload
                if ($request->hasFile('cover_image')) {
                    try {
                        $path = $request->file('cover_image')->store('covers', 'public');
                        $story->update(['cover_image' => '/storage/' . $path]);
                    } catch (\Exception $e) {
                        Log::error('Cover upload failed: ' . $e->getMessage());
                    }
                }

                return redirect()->route('author.studio', [
                    'story_id' => $story->id,
                    'chapter_id' => $chapter->id
                ])->with('success', 'Universe created! Your journey begins now.');
            });
        } catch (\Exception $e) {
            Log::error('Story creation failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Could not save your story. Please try again. Error: ' . $e->getMessage()]);
        }
    }
}
