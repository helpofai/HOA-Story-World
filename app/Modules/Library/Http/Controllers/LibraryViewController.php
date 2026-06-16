<?php

namespace App\Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Library\Models\ReadingHistoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryViewController extends Controller
{
    public function index(Request $request)
    {
        $readingNow = ReadingHistoryModel::where('user_id', Auth::id())
            ->with(['story', 'chapter'])
            ->orderBy('last_read_at', 'desc')
            ->get()
            ->map(function($history) {
                return [
                    'id' => $history->story_id,
                    'chapter_id' => $history->chapter_id,
                    'title' => $history->story->title,
                    'slug' => $history->story->slug,
                    'author' => $history->story->author->name ?? 'Unknown',
                    'cover' => $history->story->cover_image ?? 'https://picsum.photos/seed/story-'.$history->story_id.'/400/600',
                    'progress' => $history->progress_percent,
                    'current_chapter' => $history->chapter->title,
                    'last_read' => $history->last_read_at->diffForHumans(),
                    'theme' => 'blue'
                ];
            });

        return view('modules.library.index', [
            'readingNow' => $readingNow
        ]);
    }
}
