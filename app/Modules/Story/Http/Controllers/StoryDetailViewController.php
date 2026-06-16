<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;

class StoryDetailViewController extends Controller
{
    public function show(Request $request, $slug)
    {
        $story = StoryStoryModel::where('slug', $slug)
            ->with(['author', 'genres', 'chapters' => function($query) {
                $query->orderBy('order_index', 'asc');
            }])
            ->firstOrFail();

        return view('modules.story.show', [
            'story' => $story,
            'chapters' => $story->chapters
        ]);
    }
}
