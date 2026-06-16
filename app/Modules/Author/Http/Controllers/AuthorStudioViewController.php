<?php

namespace App\Modules\Author\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\ChapterStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorStudioViewController extends Controller
{
    public function index(Request $request)
    {
        $storyId = $request->query('story_id');
        $story = null;

        if ($storyId) {
            // Load specific story requested
            $story = StoryStoryModel::where('author_id', Auth::id())
                ->where('id', $storyId)
                ->with(['chapters', 'characters', 'timelineEvents'])
                ->first();
        }

        if (!$story) {
            // Default to the most recently updated story
            $story = StoryStoryModel::where('author_id', Auth::id())
                ->with(['chapters', 'characters', 'timelineEvents'])
                ->orderBy('updated_at', 'desc')
                ->first();
        }

        if (!$story) {
            // ONLY if user has absolutely NO stories, create the demo one
            $story = StoryStoryModel::create([
                'author_id' => Auth::id(),
                'title' => 'My First Epic Story',
                'slug' => 'my-first-epic-story-' . uniqid(),
                'synopsis' => 'A new journey begins here...',
                'status' => 'ongoing',
                'age_rating' => 'G'
            ]);
            
            $story->characters()->create([
                'name' => 'Protagonist Name',
                'initials' => 'PN',
                'role' => 'Protagonist',
                'age' => 20,
                'description' => 'The hero of our tale.',
                'color_theme' => 'blue'
            ]);
        }

        // Get active chapter or create first draft
        $chapterId = $request->query('chapter_id');
        $chapter = null;

        if ($chapterId) {
            $chapter = ChapterStoryModel::where('story_id', $story->id)->find($chapterId);
        }

        if (!$chapter) {
            $chapter = $story->chapters()->first();
        }

        if (!$chapter) {
            $chapter = $story->chapters()->create([
                'title' => 'Chapter 1: The Beginning',
                'content' => '<p>Once upon a time...</p>',
                'order_index' => 1,
                'status' => 'draft'
            ]);
        }

        return view('modules.author.studio', [
            'story' => $story,
            'chapter' => $chapter,
            'allChapters' => $story->chapters,
            'characters' => $story->characters,
            'timelineEvents' => $story->timelineEvents
        ]);
    }

    public function autosave(Request $request, $chapterId)
    {
        $chapter = ChapterStoryModel::findOrFail($chapterId);
        
        if ($chapter->story->author_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chapter->update([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content'),
            'words_count' => $request->input('words_count', 0),
            'characters_count' => $request->input('characters_count', 0),
        ]);

        return response()->json(['status' => 'success', 'saved_at' => now()->toDateTimeString()]);
    }

    public function createChapter(Request $request, $storyId)
    {
        $story = StoryStoryModel::where('author_id', Auth::id())->findOrFail($storyId);

        $nextOrder = ($story->chapters()->max('order_index') ?? 0) + 1;

        $chapter = $story->chapters()->create([
            'title' => 'Chapter ' . $nextOrder,
            'content' => '<p>Continue your story...</p>',
            'order_index' => $nextOrder,
            'status' => 'draft'
        ]);

        return redirect()->route('author.studio', [
            'story_id' => $story->id,
            'chapter_id' => $chapter->id
        ])->with('success', 'New chapter created!');
    }
}
