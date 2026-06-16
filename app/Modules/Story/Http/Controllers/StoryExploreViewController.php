<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\GenreStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;

class StoryExploreViewController extends Controller
{
    public function index(Request $request)
    {
        $genres = GenreStoryModel::all();
        
        $query = StoryStoryModel::query()->with('author', 'genres');

        // Simple filtering for demonstration
        if ($request->has('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('slug', $request->genre);
            });
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $stories = $query->paginate(12);

        return view('modules.story.explore', [
            'genres' => $genres,
            'stories' => $stories,
            'currentGenre' => $request->genre
        ]);
    }
}
