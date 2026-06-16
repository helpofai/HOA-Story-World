<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\ChapterStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use App\Modules\Library\Models\ReadingHistoryModel;
use App\Modules\Library\Actions\UpdateReadingStreakAction;
use App\Modules\Library\Actions\TrackReadingActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterReaderViewController extends Controller
{
    public function show(string $slug, int $chapterId)
    {
        $story = StoryStoryModel::where('slug', $slug)->firstOrFail();
        $chapter = ChapterStoryModel::where('story_id', $story->id)->findOrFail($chapterId);

        // Update Reading History and Streak for Authenticated User
        if (Auth::check()) {
            ReadingHistoryModel::updateOrCreate(
                ['user_id' => Auth::id(), 'story_id' => $story->id],
                [
                    'chapter_id' => $chapter->id,
                    'last_read_at' => now(),
                ]
            );

            // Update Streak and Activity
            (new UpdateReadingStreakAction())->execute(Auth::id());
            (new TrackReadingActivityAction())->execute(Auth::id());
        }

        // Fetch adjacent chapters for navigation
        $prevChapter = ChapterStoryModel::where('story_id', $story->id)
            ->where('order_index', '<', $chapter->order_index)
            ->orderBy('order_index', 'desc')
            ->first();

        $nextChapter = ChapterStoryModel::where('story_id', $story->id)
            ->where('order_index', '>', $chapter->order_index)
            ->orderBy('order_index', 'asc')
            ->first();

        // Increment views
        $chapter->increment('views_count');

        return view('modules.story.reader', [
            'story' => $story,
            'chapter' => $chapter,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
        ]);
    }

    public function trackProgress(Request $request, int $chapterId)
    {
        if (!Auth::check()) return response()->json(['status' => 'guest']);

        $chapter = ChapterStoryModel::findOrFail($chapterId);
        
        ReadingHistoryModel::updateOrCreate(
            ['user_id' => Auth::id(), 'story_id' => $chapter->story_id],
            [
                'chapter_id' => $chapter->id,
                'progress_percent' => $request->input('progress', 0),
                'last_read_at' => now(),
            ]
        );

        return response()->json(['status' => 'success']);
    }
}
