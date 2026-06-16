<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;

class StorySearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->query('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $stories = StoryStoryModel::where('title', 'LIKE', "%{$query}%")
            ->orWhere('synopsis', 'LIKE', "%{$query}%")
            ->with(['author', 'genres'])
            ->limit(10)
            ->get()
            ->map(function ($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'slug' => $story->slug,
                    'author' => $story->author->name ?? 'Unknown',
                    'genre' => $story->genres->first()->name ?? 'Story',
                    'cover' => $story->cover_image ?? 'https://picsum.photos/seed/'.$story->id.'/100/150',
                    'url' => route('story.show', $story->slug)
                ];
            });

        return response()->json($stories);
    }
}
