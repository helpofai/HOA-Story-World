<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\LocationStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryMapController extends Controller
{
    public function show(string $slug)
    {
        $story = StoryStoryModel::where('slug', $slug)->with('locations')->firstOrFail();
        
        return view('modules.story.map', [
            'story' => $story,
            'locations' => $story->locations
        ]);
    }

    public function storeLocation(Request $request, int $storyId)
    {
        $story = StoryStoryModel::findOrFail($storyId);
        
        // Ensure only author can add locations
        if ($story->author_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'x_pos' => 'required|numeric',
            'y_pos' => 'required|numeric',
        ]);

        $location = LocationStoryModel::create([
            'story_id' => $storyId,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'x_pos' => $validated['x_pos'],
            'y_pos' => $validated['y_pos'],
        ]);

        return response()->json($location);
    }
}
