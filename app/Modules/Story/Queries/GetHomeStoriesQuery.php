<?php

namespace App\Modules\Story\Queries;

use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Database\Eloquent\Collection;

class GetHomeStoriesQuery
{
    /**
     * Get stories grouped by homepage sections.
     *
     * @return array
     */
    public function execute(): array
    {
        return [
            'featured' => StoryStoryModel::where('is_featured', true)->with('author')->latest()->limit(5)->get(),
            'trending' => StoryStoryModel::orderBy('views_count', 'desc')->with('genres')->limit(10)->get(),
            'editor_picks' => StoryStoryModel::where('is_editor_pick', true)->with('genres')->limit(10)->get(),
            'recently_updated' => StoryStoryModel::latest('updated_at')->with('genres')->limit(10)->get(),
            'new_releases' => StoryStoryModel::latest()->with('genres')->limit(10)->get(),
        ];
    }
}
