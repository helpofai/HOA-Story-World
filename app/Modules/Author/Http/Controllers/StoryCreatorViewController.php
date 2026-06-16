<?php

namespace App\Modules\Author\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\GenreStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'genres' => 'required|array',
            'cover_image' => 'nullable|image|max:2048',
        ]);

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

        // Handle Image Upload (Basic logic)
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $story->update(['cover_image' => '/storage/' . $path]);
        }

        return redirect()->route('author.studio', ['story_id' => $story->id])
            ->with('success', 'Story created successfully! Now let\'s write your first chapter.');
    }
}
