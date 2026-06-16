<?php

namespace App\Modules\Story\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Queries\GetHomeStoriesQuery;
use App\Modules\Library\Models\ReadingHistoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StoryHomeViewController extends Controller
{
    public function __invoke(GetHomeStoriesQuery $query): View
    {
        $sections = $query->execute();

        $readingHistory = [];
        if (Auth::check()) {
            $readingHistory = ReadingHistoryModel::where('user_id', Auth::id())
                ->with(['story', 'chapter'])
                ->orderBy('last_read_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('pages.home', [
            'sections' => $sections,
            'readingHistory' => $readingHistory
        ]);
    }
}
